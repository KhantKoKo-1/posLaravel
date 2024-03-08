<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
  font-family: "Arial", sans-serif;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: #3498db; /* Warna latar belakang utama */
}

.container {
  width: 100%;
  max-width: 400px;
}

.card {
  background-color: #fff; /* Warna latar card */
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  color: #3498db; /* Warna teks pada card */
}

h2 {
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 6px;
}

input {
  padding: 10px;
  margin-bottom: 12px;
  border: 1px solid #3498db; /* Warna border input */
  border-radius: 4px;
  transition: border-color 0.3s ease-in-out;
  outline: none; /* Hapus outline pada saat focus */
}

input:focus {
  border-color: #2980b9; /* Warna border input saat focus */
}

button {
  background-color: #2980b9; /* Warna latar button */
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button:hover {
  background-color: #2c3e50; /* Warna latar button saat hover */
}

</style>
<body>
<div class="container">
  <div class="card">
    <h2>Login</h2>
    @if ($errors -> has('loginError'))
        <p style="color:red">{{$errors -> first('loginError')}}</p>
    @endif
    <form action="{{ route('loginForm') }}" method="POST">
    @csrf
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="{{ old('username') }}" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" />

      <button type="submit">Login</button>
    </form>
  </div>
</div>
</body>
</html>