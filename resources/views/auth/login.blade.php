<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label for="nip">NIP</label>
        <input id="nip" type="text" name="nip" required autofocus>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>
