@extends('_layouts.head')

@section('title', 'overzicht')

@section('main')
<main>
    <section>
        <h3>over dit project</h3>
        <p>Deze website is ontstaan uit een grote afkeer voor de gigant meta, en daarnaast uit faceboeks enige handige functie: evenementen. Ik hoop dat deze website voor sommigen de stap van facebook kan vergemakkelijken. Ik heb lekker veel plezier aan het maken van dit platform. En uhm... ik zou het super hard apprecieëren als je jouw bedenkingen over deze website wilt delen met mij. Alle soort feedback is welkom :)</p>
        <p onclick="copyMail('gustave.curtil@tutanota.com')"><u>gustave.curtil@tutanota.com</u></p>
    </section>
</main>
@endsection

@section('script')
<script>
    function copyMail(link) {
            navigator.clipboard.writeText(link).then(() => {
                alert("❀ e-mailadres is gekopieerd ❀");
            }).catch(err => {
                console.error("Failed to copy: ", err);
                alert("Link kopieeren is niet gelukt precies...");
            });
        }
</script>
@endsection