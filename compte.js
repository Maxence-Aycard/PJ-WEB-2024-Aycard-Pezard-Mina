document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const accountType = document.getElementById('account-type').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const loginData = {
        type: accountType,
        username: username,
        password: password
    };

    // Envoyer les données au backend pour l'authentification
    fetch('https://votrebackend.com/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loginData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Rediriger vers le tableau de bord du compte
            window.location.href = `dashboard_${accountType}.html`;
        } else {
            alert('Identifiant ou mot de passe incorrect.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});
