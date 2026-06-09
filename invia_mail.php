<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Raccogli e sanifica i dati del form
    $nome = strip_tags(trim($_POST["nome"] ?? $_POST["Nome"] ?? ""));
    $cognome = strip_tags(trim($_POST["cognome"] ?? $_POST["Cognome"] ?? ""));
    $email_utente = filter_var(trim($_POST["email"] ?? $_POST["Email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $telefono = strip_tags(trim($_POST["telefono"] ?? $_POST["Telefono"] ?? ""));
    $messaggio = strip_tags(trim($_POST["messaggio"] ?? $_POST["Messaggio"] ?? ""));
    $servizio = strip_tags(trim($_POST["servizio"] ?? $_POST["Servizio"] ?? "Generale"));

    // Configura i dati dell'email
    $ricevente = "info@LaFioreriadiAnna.it"; // Metti qui la TUA mail di Aruba
    $oggetto = "[$servizio] Nuova richiesta da: $nome $cognome";
    
    // Costruisci il corpo del messaggio
    $corpo_mail = "Hai ricevuto una nuova richiesta dal tuo sito web.\n";
    $corpo_mail .= "============================================\n\n";
    $corpo_mail .= "Servizio richiesto: $servizio\n\n";
    $corpo_mail .= "--- DATI CONTATTO ---\n";
    $corpo_mail .= "Nome: $nome $cognome\n";
    $corpo_mail .= "Email: $email_utente\n";
    if (!empty($telefono)) $corpo_mail .= "Telefono: $telefono\n";
    $corpo_mail .= "\n";

    // Campi specifici per servizio
    $campi_extra = [];
    $campi_ignorati = ['nome', 'Nome', 'cognome', 'Cognome', 'email', 'Email', 
                       'telefono', 'Telefono', 'messaggio', 'Messaggio', 
                       'servizio', 'Servizio'];

    foreach ($_POST as $chiave => $valore) {
        if (!in_array($chiave, $campi_ignorati) && !empty($valore)) {
            $etichetta = ucfirst(str_replace('_', ' ', $chiave));
            $valore_pulito = strip_tags(trim($valore));
            $corpo_mail .= "$etichetta: $valore_pulito\n";
        }
    }

    if (!empty($messaggio)) {
        $corpo_mail .= "\n--- MESSAGGIO ---\n$messaggio\n";
    }

    // Intestazioni per l'invio (Headers)
    $headers = "From: info@tuodominio.it\r\n"; // Obbligatorio usare una mail del dominio su Aruba
    $headers .= "Reply-To: $email_utente\r\n"; // Se rispondi alla mail, risponderai all'utente
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Determina la pagina di ritorno in base al servizio
    $pagine_ritorno = [
        'Matrimonio' => 'servizio-matrimoni.html',
        'Onoranze Funebri' => 'servizio-onoranze.html',
        'Allestimenti Eventi' => 'servizio-allestimenti.html',
        'Consegna a Domicilio' => 'servizio-consegna.html',
        'Generale' => 'contatti.html',
    ];
    $pagina_ritorno = $pagine_ritorno[$servizio] ?? 'contatti.html';

    // Invia l'email
    if (mail($ricevente, $oggetto, $corpo_mail, $headers)) {
        // Messaggio inviato con successo
        echo '<!DOCTYPE html><html lang="it"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Messaggio Inviato | LaFioreriaDiAnna</title>';
        echo '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">';
        echo '<script src="https://cdn.tailwindcss.com"></script>';
        echo '<script>tailwind.config={theme:{extend:{colors:{sage:"#768875",cream:"#fcfaf4",accent:"#b58d67"},fontFamily:{serif:["Playfair Display","serif"],sans:["Inter","sans-serif"]}}}}</script>';
        echo '</head><body class="font-sans text-stone-800 bg-cream min-h-screen flex items-center justify-center">';
        echo '<div class="text-center max-w-lg mx-auto px-4">';
        echo '<div class="w-20 h-20 bg-sage/10 rounded-full flex items-center justify-center mx-auto mb-8"><svg class="w-10 h-10 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>';
        echo '<h1 class="font-serif text-4xl mb-4 text-sage">Grazie!</h1>';
        echo '<p class="text-stone-500 text-lg mb-8">Il tuo messaggio è stato inviato correttamente.<br>Ti ricontatteremo il prima possibile.</p>';
        echo '<a href="' . $pagina_ritorno . '" class="bg-sage text-white px-8 py-4 rounded-full font-bold hover:bg-accent transition-colors inline-block">Torna Indietro</a>';
        echo '</div></body></html>';
    } else {
        // Errore nel server
        echo '<!DOCTYPE html><html lang="it"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Errore | LaFioreriaDiAnna</title>';
        echo '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">';
        echo '<script src="https://cdn.tailwindcss.com"></script>';
        echo '<script>tailwind.config={theme:{extend:{colors:{sage:"#768875",cream:"#fcfaf4",accent:"#b58d67"},fontFamily:{serif:["Playfair Display","serif"],sans:["Inter","sans-serif"]}}}}</script>';
        echo '</head><body class="font-sans text-stone-800 bg-cream min-h-screen flex items-center justify-center">';
        echo '<div class="text-center max-w-lg mx-auto px-4">';
        echo '<div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8"><svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>';
        echo '<h1 class="font-serif text-4xl mb-4 text-stone-800">Ci Dispiace</h1>';
        echo '<p class="text-stone-500 text-lg mb-8">Si è verificato un errore durante l\'invio.<br>Riprova più tardi o contattaci telefonicamente al <strong>0122 32469</strong>.</p>';
        echo '<a href="' . $pagina_ritorno . '" class="bg-sage text-white px-8 py-4 rounded-full font-bold hover:bg-accent transition-colors inline-block">Riprova</a>';
        echo '</div></body></html>';
    }
} else {
    // Se qualcuno prova ad accedere alla pagina direttamente, reindirizzalo al form
    header("Location: contatti.html");
    exit;
}
?>