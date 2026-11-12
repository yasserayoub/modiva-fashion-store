
@extends('layouts.admin')

@section('title', 'Color Management')
@section('page-heading', 'Color Management')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Color Management</h2>
            <p>Manage the colors available for your products.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
            Back to Dashboard
        </a>
    </div>

    <!-- Add Color -->
    <div class="products-card" style="padding:24px; margin-bottom:25px;">

        <h3 style="margin-top:0; margin-bottom:20px;">Add New Color</h3>

        <form action="{{ route('admin.colors.store') }}" method="POST">
            @csrf

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr auto;
                gap:15px;
                align-items:end;
            ">

                <div class="form-group">
                    <label for="name">Color Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Example: Green"
                        required
                    >

                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hexcode">HEX Code</label>

                    <div style="display:flex; gap:10px; align-items:center;">
                        <input
                            type="text"
                            name="hexcode"
                            id="hexcode"
                            value="{{ old('hexcode', '#000000') }}"
                            placeholder="#000000"
                            pattern="^#[0-9A-Fa-f]{6}$"
                            maxlength="7"
                            required
                        >

                        <input
                            type="color"
                            id="colorPicker"
                            value="#000000"
                            style="width:45px; height:42px; padding:2px; cursor:pointer;"
                            title="Choose a color"
                        >
                    </div>

                    @error('hexcode')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="add-product-btn">
                    + Add Color
                </button>

            </div>
        </form>
    </div>

    <!-- Colors Table -->
    <div class="products-card" style="padding:24px;">

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message" style="display:block; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <h3 style="margin-top:0; margin-bottom:20px;">Available Colors</h3>

        <div class="table-container">
            <table class="orders-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>HEX Code</th>
                        <th>Product Variants</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($colors as $color)

                        <tr>
                            <td>{{ $color->id }}</td>

                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="
                                        width:28px;
                                        height:28px;
                                        border-radius:50%;
                                        background:{{ $color->hexcode }};
                                        border:1px solid #ddd;
                                        display:inline-block;
                                        flex-shrink:0;
                                    "></span>

                                    <strong>{{ $color->name }}</strong>
                                </div>
                            </td>

                            <td>
                                <code>{{ strtoupper($color->hexcode) }}</code>
                            </td>

                            <td>{{ $color->variants_count }}</td>

                            <td>
                                <button
                                    type="button"
                                    class="edit-btn"
                                    onclick="editColor(
                                        {{ $color->id }},
                                        @js($color->name),
                                        @js($color->hexcode)
                                    )"
                                >
                                    Edit
                                </button>

                                <form
                                    action="{{ route('admin.colors.destroy', $color->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this color?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty-orders">
                                No colors found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- Edit Color Modal -->
<div id="editColorModal" class="color-modal">

    <div class="color-modal-content">

        <h3>Edit Color</h3>

        <form id="editColorForm" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="editName">Color Name</label>
                <input type="text" name="name" id="editName" required>
            </div>

            <div class="form-group">
                <label for="editHexcode">HEX Code</label>

                <div style="display:flex; gap:10px; align-items:center;">
                    <input
                        type="text"
                        name="hexcode"
                        id="editHexcode"
                        pattern="^#[0-9A-Fa-f]{6}$"
                        maxlength="7"
                        required
                    >

                    <input
                        type="color"
                        id="editColorPicker"
                        value="#000000"
                        style="width:45px; height:42px; padding:2px; cursor:pointer;"
                    >
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeColorModal()">
                    Cancel
                </button>

                <button type="submit" class="add-product-btn">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.color-modal {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.color-modal-content {
    background:white;
    width:100%;
    max-width:450px;
    padding:25px;
    border-radius:10px;
}

.color-modal-content h3 {
    margin-top:0;
    margin-bottom:20px;
}

.color-modal-content .form-group {
    margin-bottom:18px;
}

.color-modal-content input[type="text"] {
    width:100%;
    box-sizing:border-box;
}

.color-modal-content .form-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

@media(max-width:700px) {
    .products-page form > div[style*="grid-template-columns"] {
        grid-template-columns:1fr !important;
    }
}
</style>

<script>
function editColor(id, name, hexcode) {
    document.getElementById('editName').value = name;
    document.getElementById('editHexcode').value = hexcode;
    document.getElementById('editColorPicker').value = hexcode;

    document.getElementById('editColorForm').action =
        "{{ url('/admin/colors') }}/" + id;

    document.getElementById('editColorModal').style.display = 'flex';
}

function closeColorModal() {
    document.getElementById('editColorModal').style.display = 'none';
}

// Add form color picker
const colorPicker = document.getElementById('colorPicker');
const hexcodeInput = document.getElementById('hexcode');

colorPicker.addEventListener('input', function() {
    hexcodeInput.value = this.value.toUpperCase();
});

hexcodeInput.addEventListener('input', function() {
    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
        colorPicker.value = this.value;
    }
});

// Edit form color picker
const editColorPicker = document.getElementById('editColorPicker');
const editHexcodeInput = document.getElementById('editHexcode');

editColorPicker.addEventListener('input', function() {
    editHexcodeInput.value = this.value.toUpperCase();
});

editHexcodeInput.addEventListener('input', function() {
    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
        editColorPicker.value = this.value;
    }
});

document.getElementById('editColorModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeColorModal();
    }
});
</script>

@endsection
