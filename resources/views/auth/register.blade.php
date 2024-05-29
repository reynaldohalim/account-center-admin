<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="nip">NIP</label>
        <input id="nip" type="text" name="nip" required autofocus>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>
    <div>
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Register</button>
</form>
