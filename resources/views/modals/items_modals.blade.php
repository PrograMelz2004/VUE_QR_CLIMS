<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addItemForm">
                    @csrf
                    <div class="mb-3">
                        <label>Item Name</label>
                        <input type="text" id="addItemName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" id="addItemQuantity" class="form-control" required>
                        <input type="text" id="qrcode" class="form-control" value="{{ $codee }}" readonly hidden>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editItemForm">
                    @csrf
                    <input type="hidden" id="editItemId">
                    <div class="mb-3">
                        <label>Item Name</label>
                        <input type="text" id="editItemName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" id="editItemQuantity" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Your QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrCodeImage" src="" alt="QR Code" style="max-width: 100%;">
            </div>
        </div>
    </div>
</div>