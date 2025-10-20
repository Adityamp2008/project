@extends('layouts.add')

@section('content')
<div class="container">
  <h4>Edit Akun</h4>

  <form action="{{ route('users.update', $user->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
      </div>

      <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
      </div>

      <div class="mb-3">
          <label>Role</label>
          <select name="role" class="form-control" required>
              <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
              <option value="kepdin" {{ $user->role == 'kepdin' ? 'selected' : '' }}>Kepdin</option>
          </select>
      </div>

      <div class="mb-3">
          <label>Password (kosongkan jika tidak diganti)</label>
          <input type="password" name="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
