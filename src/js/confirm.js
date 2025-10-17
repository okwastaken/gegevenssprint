
// bevestigingen voor reset clicks en verwijder account
document.addEventListener('DOMContentLoaded', () => {
    // vind formulieren die buttons hebben met name="clicks" of name="verwijder"
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', (e) => {
            const submitter = e.submitter || document.activeElement; // moderne fallback
            if (!submitter) return; // niks doen


            if (submitter.name === 'clicks') {
                const ok = confirm('Weet je zeker dat je alle clicks wilt resetten? Deze actie kan niet ongedaan worden gemaakt.');
                if (!ok) e.preventDefault();
            }
            if (submitter.name === 'verwijder') {
                const ok = confirm('Weet je zeker dat je je account wilt verwijderen? Je data wordt permanent verwijderd.');
                if (!ok) e.preventDefault();
            }
        })
    })
})