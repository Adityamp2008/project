@extends('layouts.add')

@section('content')
<div class="container">
  <h4>Tambah Akun</h4>

  <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
          <label>Role</label>
          <select name="role" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="petugas">Petugas</option>
              <option value="kepdin">Kepdin</option>
          </select>
      </div>

      <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
