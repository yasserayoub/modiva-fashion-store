
@extends('layouts.admin')

@section('title', 'Size Management')
@section('page-heading', 'Size Management')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Size Management</h2>
            <p>Manage the sizes available for your products.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
            Back to Dashboard
        </a>
    </div>

    <div class="products-card" style="padding:24px; margin-bottom:25px;">

        <h3 style="margin-top:0; margin-bottom:20px;">Add New Size</h3>

        <form action="{{ route('admin.sizes.store') }}" method="POST">
            @csrf

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr auto;
                gap:15px;
                align-items:end;
            ">

                <div class="form-group">
                    <label for="name">Size Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Example: XXXL"
                        required
                    >

                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sortorder">Display Order</label>
                    <input
                        type="number"
                        name="sortorder"
                        id="sortorder"
                        value="{{ old('sortorder', 0) }}"
                        min="0"
                        required
                    >

                    @error('sortorder')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="add-product-btn">
                    + Add Size
                </button>

            </div>
        </form>
    </div>

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

        <h3 style="margin-top:0; margin-bottom:20px;">Available Sizes</h3>

        <div class="table-container">
            <table class="orders-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size Name</th>
                        <th>Display Order</th>
                        <th>Product Variants</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sizes as $size)

                        <tr>
                            <td>{{ $size->id }}</td>

                            <td>
                                <strong>{{ $size->name }}</strong>
                            </td>

                            <td>{{ $size->sortorder }}</td>

                            <td>{{ $size->variants_count }}</td>

                            <td>
                                <button
                                    type="button"
                                    class="edit-btn"
                                    onclick="editSize(
                                        {{ $size->id }},
                                        @js($size->name),
                                        {{ $size->sortorder }}
                                    )"
                                >
                                    Edit
                                </button>

                                <form
                                    action="{{ route('admin.sizes.destroy', $size->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this size?')"
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
                                No sizes found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- Edit Size Modal -->
<div id="editSizeModal" class="size-modal">

    <div class="size-modal-content">

        <h3>Edit Size</h3>

        <form id="editSizeForm" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="editName">Size Name</label>
                <input type="text" name="name" id="editName" required>
            </div>

            <div class="form-group">
                <label for="editSortorder">Display Order</label>
                <input type="number" name="sortorder" id="editSortorder" min="0" required>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeSizeModal()">
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
.size-modal {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.size-modal-content {
    background:white;
    width:100%;
    max-width:450px;
    padding:25px;
    border-radius:10px;
}

.size-modal-content h3 {
    margin-top:0;
    margin-bottom:20px;
}

.size-modal-content .form-group {
    margin-bottom:18px;
}

.size-modal-content input {
    width:100%;
    box-sizing:border-box;
}

.size-modal-content .form-actions {
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
function editSize(id, name, sortorder) {
    document.getElementById('editName').value = name;
    document.getElementById('editSortorder').value = sortorder;

    document.getElementById('editSizeForm').action =
        "{{ url('/admin/sizes') }}/" + id;

    document.getElementById('editSizeModal').style.display = 'flex';
}

function closeSizeModal() {
    document.getElementById('editSizeModal').style.display = 'none';
}

document.getElementById('editSizeModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeSizeModal();
    }
});
</script>

@endsection
