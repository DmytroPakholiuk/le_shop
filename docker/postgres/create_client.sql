insert
into oauth_clients
    (id, user_id, name, redirect, personal_access_client, password_client, revoked)
values
    (4, 1, 'pkce', 'http://view.le.shop:23000/auth', true, false, false);