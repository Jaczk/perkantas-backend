@extends('admin.layouts.base')

@section('title', 'Pengadaan')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {{-- Alert Here --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengadaan barang</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form enctype="multipart/form-data" method="POST"
                    action="{{ route('admin.procurement.update', $procurements->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="status" class="form-label">Pilih Status :</label>
                            <select {{-- conditional status --}} class="custom-select font-weight-bold" {{-- @if ($procurements->status === 'pending')
                                class="custom-select font-weight-bold text-info" 
                            @elseif($procurements->status === "approved")
                                class="custom-select font-weight-bold text-success" 
                            @else
                                class="custom-select font-weight-bold text-danger" 
                            @endif --}}
                                name="status">
                                <option class="text-warning font-weight-bold" value="not_added" @selected($procurements->status == 'not_added')>
                                    DIAJUKAN</option>
                                <option class="text-success font-weight-bold" value="added" @selected($procurements->status == 'added')>
                                    TERSEDIA</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="title">Pesan</label>
                            <textarea placeholder="tulis pesan kepada anggota terkait pengajuan barang..." 
                            name="message" class="form-control" id="message" rows="3">{{ $procurements->message }}</textarea>
                        </div> --}}
                    </div>


                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" onclick="confirmEditForm(event)">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function confirmEditForm(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Simpan perubahan?',
                text: 'Kategori akan diperbarui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form
                    event.target.form.submit();
                }
            });
        }
    </script>
@endsection