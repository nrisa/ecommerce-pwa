@extends('shop')

@section('content')
<div class="container pt-4 pb-5">
  <h3 class="mb-5">Profile User</h3>
  <form action="{{ route('user.update', ['id' => auth()->user()->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-md-3 d-flex flex-column align-items-center">
        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center bg-secondary"
          style="width:200px;height: 200px;">
          @if(auth()->user()->foto)
              <img src="{{ asset('profile/'.auth()->user()->foto) }}" alt="profil" height="110%">
          @else
              <i class="fa-solid fa-user text-white" style="font-size: 82px"></i>
          @endif
        </div>
        <div class="mb-3">
          <label for="input" class="text-center d-block my-2">Upload Foto</label>
          <input type="file" class="form-control" id="input" name="foto">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" value="{{ auth()->user()->email }}" class="form-control" id="exampleInputEmail1"
            aria-describedby="emailHelp" name="email">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="input" class="form-label">Name</label>
          <input type="text" value="{{ auth()->user()->name }}" class="form-control" name="name" id="input">
        </div>
        <div class="mb-3">
          <label for="input" class="form-label">No HP</label>
          <input type="text" value="{{ auth()->user()->no_hp }}" class="form-control" name="no_hp" id="input">
        </div>
        <div class="mb-3">
          <label for="input" class="form-label">Alamat</label>
          <textarea class="form-control" id="input" name="alamat">{{ auth()->user()->alamat }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      <div class="col-md-3">
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">Info User</h4>
          <p>Buat data Profile berdasarkan data yang valid.</p>
          <hr>
          <p class="mb-0">Terimakasih.</p>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
</script>
@endsection