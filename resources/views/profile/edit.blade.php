@extends('layouts.home')
@section('title','الصفحة الشخصية')

@section('css')
<style>

body {
  background-color: #f5f7fa;
  color: #333;
  direction: rtl;
  padding-bottom: 50px;
}

.profile-container {
  max-width: 800px;
  margin: 150px 400px;
  padding: 0 1rem;
}

.profile-card {
  background: white;
  border-radius: 12px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.profile-card h2 {
  margin-bottom: 1rem;
  color: #1e293b;
}

.profile-card p {
  margin-bottom: 1rem;
  color: #e11d48;
}

.profile-input {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 1rem;
}

.profile-btn {
  background-color: var(--first-color);
  color: white;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.profile-btn:hover {
  background-color: #2563eb;
}
</style>
@endsection

@section('content')
<main class="profile-container">
  <section class="profile-card">
    <h2>تحديث المعلومات الشخصية</h2>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
      <input
        type="text"
        class="profile-input"
        name="name"
        placeholder="الاسم الكامل"
        value="{{ old('name', auth()->user()->name) }}"
        required
        autofocus
        autocomplete="name"
      />

      <input
        type="text"
        class="profile-input"
        name="username"
        placeholder="البريد الإلكتروني"
        value="{{ old('username', auth()->user()->username) }}"
        required
      />

      <button type="submit" class="profile-btn">تحديث المعلومات</button>
    </form>
  </section>

  <section class="profile-card">
    <h2>تغيير كلمة المرور</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')
      <input type="password" name="current_password" class="profile-input" placeholder="كلمة المرور الحالية" required />
      <input type="password" name="password" class="profile-input" placeholder="كلمة المرور الجديدة" required />
      <input type="password" name="password_confirmation" class="profile-input" placeholder="تأكيد كلمة المرور" required />
      <button type="submit" class="profile-btn">تغيير كلمة المرور</button>
    </form>
  </section>
</main>
@endsection
