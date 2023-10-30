<?php ?>


<form method="post" action="{{ route('signup') }}">
    @csrf

    <label for="name">Username:</label>
    <input type="text" name="name">

    <label for="email">Email:</label>
    <input type="text" name="email">

    <label for="password">Password:</label>
    <input type="password" name="password">
    <button>Signup</button>
</form>
