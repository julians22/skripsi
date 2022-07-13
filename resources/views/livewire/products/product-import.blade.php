<div>
    {{-- Success is as dangerous as failure. --}}
    <div
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >

        <div class="form-group">
            <label for="selectFile">Select File</label>
            <div class="custom-file">
                <input
                    type="file"
                    class="custom-file-input"
                    id="customFile"
                    wire:model="file"
                    wire:loading.attr="disabled"
                >
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>

        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
        </div>

        <button
            type="button"
            wire:click="import"
            class="btn btn-primary"
            wire:loading.attr="disabled"
            >Process</button>

        @if ($products)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <p>
                            Berikut adalah hasil proses data anda!
                            <strong>Jika anda yakin dengan data berikut, silahkan klik tombol <code>"Simpan"</code> dibawah!</strong>
                        </p>
                        <p>
                            Perlu anda ketahui sebelum melanjutkan proses ini:
                            <ul>
                                <li>
                                    <strong>
                                        Jika nama dan code produk yang anda masukkan sudah ada, maka data akan di perbarui dengan data yang baru.
                                    </strong>
                                </li>
                                <li>
                                    <strong>
                                        Jika data yang anda masukkan tidak ada, maka data akan ditambahkan sebagai data baru & menggunakan kategori default <code>"Tanpa Kategori"</code>
                                    </strong>
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="20%">Name</th>
                                <th width="20%">Kode</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['code'] }}</td>
                                    <td>{{ rupiah($product['price']) }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- product total --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p>
                                    <strong>
                                        Total produk yang akan dimasukkan: <code>{{ count($products) }}</code>
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <button
                        type="button"
                        wire:click="save"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                        >Simpan
                    </button>
                </div>
            </div>

        @endif

    </div>
</div>
