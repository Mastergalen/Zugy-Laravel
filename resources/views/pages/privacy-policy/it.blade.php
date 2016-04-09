@section('title', 'PROTEZIONE DELLA PROPRIETÁ INTELLETTUALE')
@section('meta_description', 'PROTEZIONE DELLA PROPRIETÁ INTELLETTUALE - ' . config('site.name'))

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>PROTEZIONE DELLA PROPRIETÁ INTELLETTUALE</h1>
    </div>
    <p>Questa politica sulla privacy illustra le norme sulla privacy per {!! env('APP_URL') !!}. Questa politica sulla privacy si applica esclusivamente alle informazioni raccolte da questo sito web. Esso ti avviserà di quanto segue:</p>

    <ol>
        <li>Quali dati personali vengono raccolti da voi attraverso il sito web, come viene utilizzato e con i quali possono essere condivise.</li>
        <li>Quali scelte sono disponibili per voi per quanto riguarda l'uso dei vostri dati?</li>
        <li>Le procedure di sicurezza in atto per proteggere l'uso improprio delle informazioni.</li>
        <li>Come si può correggere eventuali inesattezze nelle informazioni.</li>
    </ol>

    <h2>Raccolta, utilizzo e condivisione</h2>
    <p>Si mantiene il pieno diritto delle informazioni raccolte su questo sito. Abbiamo accesso a / raccogliere e conservare informazioni che volontariamente ci date via e-mail / Google / Facebook o altro contatto diretto da voi.</p>
    <p>Useremo le informazioni per rispondere a voi, per quanto riguarda il motivo che ci ha contattato. Anche in questo caso, ci sarà mantenere i diritti delle informazioni e utilizzarlo in modo anonimo con qualsiasi terzo di fiducia al di fuori della nostra organizzazione.</p>
    <p>A meno che non ci chiedete di non farlo, potremmo contattarti tramite e-mail in futuro per dirvi di offerte speciali, nuovi prodotti o servizi, o modifiche a questa politica sulla privacy.</p>

    <h2>L'accesso e il controllo sulle informazioni</h2>
    <p>Si può scegliere di eventuali futuri contatti da noi in qualsiasi momento, dato un preavviso di 30 giorni. È possibile effettuare le seguenti operazioni in qualsiasi momento contattandoci tramite l'indirizzo e-mail o numero di telefono riportati sulla nostra Homepage:</p>
    <ul>
        <li>visualizzare i dati in nostro possesso, se del caso.</li>
        <li>Modifica / correggere i dati in nostro possesso.</li>
        <li>Esprimere qualsiasi dubbio in merito all'uso dei dati.</li>
    </ul>

    <h2>Sicurezza</h2>
    <p>Prendiamo precauzioni per proteggere i dati. Quando si invia informazioni sensibili tramite il sito web, le informazioni sono protette sia online che offline.</p>
    <p>Ovunque raccogliamo informazioni sensibili (come i dati di carta di credito), tali informazioni vengono criptati e trasmessi a noi in modo sicuro. È possibile verificare questo guardando l'icona di un lucchetto chiuso nella parte inferiore del browser web, o alla ricerca di "https" all'inizio dell'indirizzo della pagina web.</p>
    <p>Oltre ad utilizzare la crittografia per proteggere le informazioni sensibili trasmesse on-line, abbiamo anche proteggiamo le vostre informazioni in linea. Soltanto i dipendenti che hanno bisogno delle informazioni per svolgere un lavoro specifico (per esempio, la fatturazione o il servizio clienti) hanno accesso alle informazioni personali. I computer / server in cui sono memorizzati i dati personali sono conservati in un ambiente sicuro.</p>

    <h2>Aggiornamenti</h2>
    <p>Aggiornato nostra politica sulla privacy può cambiare di volta in volta e tutti gli aggiornamenti saranno pubblicati su questa pagina.</p>


    <h2>Ordini</h2>
    <p>Chiediamo informazioni da voi nel modulo d'ordine. Per comprare da noi, è necessario fornire informazioni di contatto (come nome e indirizzo di spedizione) e le informazioni finanziarie (come il numero di carta di credito, data di scadenza). Queste informazioni sono utilizzate ai fini della fatturazione e per riempire i vostri ordini. Se abbiamo problemi di elaborazione di un ordine, faremo utilizzare queste informazioni per contattare l'utente.</p>

    <h2>Compartecipazione</h2>
    <p>Condividiamo le informazioni demografiche aggregate con i nostri partner e inserzionisti. Questo non è legata ad alcuna informazione personale che possa identificare una persona. Collaboriamo con un altro partito per fornire servizi specifici. Quando l'utente si iscrive per questi servizi, condivideremo i nomi, o altre informazioni di contatto che è necessario per la terza parte per fornire questi servizi. Queste parti non sono autorizzati a utilizzare dati personali tranne che per lo scopo di fornire questi servizi.</p>

    <h2>Survey & Concorsi</h2>
    <p>Di tanto in tanto il nostro sito richiede informazioni tramite sondaggi o concorsi. La partecipazione a questi sondaggi o concorsi è completamente volontaria e si può scegliere se partecipare o meno e quindi divulgare queste informazioni. Le informazioni richieste possono includere informazioni di contatto (come nome e indirizzo di spedizione), e informazioni demografiche (come il codice postale, il livello di età). Informazioni di contatto saranno utilizzati per informare i vincitori e assegnare i premi. Le informazioni verranno utilizzate per scopi di monitoraggio o migliorare l'uso e la soddisfazione di questo sito.</p>

    <p>Se ritenete che non stiamo tenendo fede da questa politica sulla privacy, è necessario contattare immediatamente via e-mail {{ config('site.email.support') }}.</p>

    <p>Ultimo aggiornamento: 5 Aprile 2016</p>
@endsection