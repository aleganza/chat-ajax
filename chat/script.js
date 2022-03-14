// toggle tema chiaro/scuro 
toggleTheme();
function toggleTheme(){
    var toggle = document.getElementById("theme-toggle");

    var storedTheme = localStorage.getItem('theme') || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
    if (storedTheme)
        document.documentElement.setAttribute('data-theme', storedTheme);
    
    toggle.onclick = function() {
        $("*:not()").css({
            transition: "0.5s ease-in-out"
        });
    
        var currentTheme = document.documentElement.getAttribute("data-theme");
        var targetTheme = "light";
        if (currentTheme == "light") {
            targetTheme = "dark";
        }
        document.documentElement.setAttribute('data-theme', targetTheme);
        localStorage.setItem('theme', targetTheme);
    
        setTimeout(function(){
            $("*").css({
                transition: "0s"
            });
        }, 500);
    }
}

/* mostra lista dei contatti dove a = utenti, b = ultimo messaggio)*/
showList();
async function showList(){
    const url = "queries/showList.php";

    const response = await fetch (url)
        .catch(err => {
            console.log(err.response.data);
        });
    const data = await response.json();
    showRegistered(); 
    showListHTML(data.a, data.b);
}
// stampa del nome nella sezione userSection
async function showRegistered(){
    const url = "queries/getRegisteredId.php";
    const response = await fetch (url)
        .catch(err => {
            console.log(err.response.data);
        });
    const data = await response.json();
    
    var element = document.getElementById("registeredUser");
    element.innerHTML = data.b;
}
// stampa lista contatti
function showListHTML(a, b){
    var list = document.getElementById("list");
    for(let i = 0; i < a.length; i++){
        var button = document.createElement("button");
        button.id = "showChat";
        button.classList.add("bg"); // sfondo
        var wrapper_1 = document.createElement("div");
        wrapper_1.classList.add("wrapper-1");
        var img = document.createElement("div");
        img.classList.add("img");
        var imgSrc = document.createElement("img");
        imgSrc.src = "img/propic/default/default_propic.png";
        img.appendChild(imgSrc);

        var wrapper_2 = document.createElement("div");
        wrapper_2.classList.add("wrapper-2");
        var contact = document.createElement("div");
        contact.classList.add("contact");
        var lastMsg = document.createElement("p");
        lastMsg.classList.add("lastMsg");

        list.appendChild(button);
        // do al bottone un value pari al contatto che rappresenta
        button.value = a[i]['nome'];
        // converto in stringa quel nome del contatto
        var nome = String(a[i]['nome']);
        // attribuisco funzione onclick al bottone, la quale passa per parametro il value di quel bottone
        $('button[value="'+nome+'"]').attr('onclick','showChat(this.value)');

        button.appendChild(wrapper_1);
        wrapper_1.appendChild(img);
        wrapper_1.appendChild(wrapper_2);
        wrapper_2.appendChild(contact);
        contact.innerHTML = a[i]['nome'];
        wrapper_2.appendChild(lastMsg);
        lastMsg.innerHTML = b[i];
    }
}

/* mostra chat premendo sul contatto */
function showChat(nome){
    var doScroll = true; // se partire dal basso o no
    const url = "queries/showChat.php";
    const delay = 250; // delay del loop
    // cancello eventuali precedenti loop
    if(typeof loop !== 'undefined')
        clearInterval(loop);
    
    setActive(nome); // evidenzio chat che premo
    showChatFetch(nome, url, doScroll); // mostro la chat
    doScroll = false // se eseguire o meno lo scroll automatico verso il basso
    // rimetto in loop la chat per mostrare eventuali messaggi nuovi in arrivo
    loop = setInterval(function (){
        showChatFetch(nome, url, doScroll);
    }, delay);
    
    document.getElementById("sendMsgBox").style.visibility = "visible"; // sezione invio messaggio diventa visibile
    var input = document.getElementById('messageId');
    alwaysType(input); // cursore su scrivi messaggio
}
// fetch per mostrare chat con i messaggi
async function showChatFetch(nome, url, doScroll){
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(nome)
        }).catch(err => {
            console.log(err.response.data);
        });
        const data = await response.json();
        // mostro chat
        showChatHTML(data.chat, data.messaggi, data.registeredId, nome, doScroll);
}
// mostro chat
function showChatHTML(chat, messaggi, registeredId, nome, doScroll){
    // se ho chat stampate in precedenza, le cancello
    var box = document.getElementById("box");
    box.innerHTML = "";
    // mostra box per invio messaggio
    printMsg(chat, messaggi, registeredId, box);
    // mostra nome e foto profilo di chi stai messaggiando
    printDisplayName(nome);
    
    /* lo scrolL automatico fino in basso della chat viene eseguito solo se:
       - se doScroll è true: quindi abbiamo appena premuto sul contatto per visualizzare la chat
       - se con lo scroll ci troviamo negli ultimi "altezzaScroll" pixel (nostro caso 60): in questo modo esegue lo scroll
            solo se abbiamo appena inviato un messaggio, non anche quando stiamo scrollendo la chat in alto per vedere
            i messaggi meno recenti

    */
    var altezzaScroll = 60 // limite da cui far partire lo scroll
    if( box.scrollTop >= ((box.scrollHeight - box.offsetHeight) - altezzaScroll) || doScroll){
        /* console.log("scrollTop: "+box.scrollTop);
        console.log("scrollHeight: "+box.scrollHeight);
        console.log("offsetHeight: "+box.offsetHeight); */
        scrollToBottom(box);
    }
}
// mostra nome e foto profilo di chi stai messaggiando
function printDisplayName(nome){
    var name = document.getElementById("wrapperDisplay").getElementsByTagName('p')[0]; // nome
    name.innerHTML = nome;   
}
// stampa dei messaggi
function printMsg(chat, messaggi, registeredId, box){
    // ciclo per ogni messaggio
    for(let i=0; i < messaggi.length; i++){
        // controllo da che parte vanno i messaggi
        if(registeredId == messaggi[i]['utenteId']){
            // stampa messaggi inviati
            var msg_miei = document.createElement("div");
            msg_miei.classList.add("msg");
            msg_miei.classList.add("miei");
            var p = document.createElement("p");
            p.classList.add("text");

            box.appendChild(msg_miei);
            msg_miei.appendChild(p);
            p.innerHTML = messaggi[i]['testo'];
        }else{
            // stampa messaggi ricevuti
            var msg_altrui = document.createElement("div");
            msg_altrui.classList.add("msg");
            msg_altrui.classList.add("altrui");
            var p = document.createElement("p");
            p.classList.add("text");

            box.appendChild(msg_altrui);
            msg_altrui.appendChild(p);
            p.innerHTML = messaggi[i]['testo'];
        }
    }
}
// setto contatto attivo sulla list
function setActive(nome){ 
    // riassegno .bg a tutti
    $(".left .list button").removeClass("bgActive").addClass("bg");

    // do .bgActive a quello attivo
    $("#showChat[value="+nome+"]").removeClass("bg").addClass("bgActive");
}
// scroll delle chat parte dal basso
function scrollToBottom(element){
    element.scrollTo(0, element.scrollHeight);
}
// posiziona cursore sempre su scrittura di un messaggio 
function alwaysType(input){
    input.focus();
    input.select();
}
// se scrivo un messaggio e premo ENTER, esegue la funzione del bottone
var input = document.getElementById("messageId");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault(); 
   document.getElementById("sendMsg").click();
  }
});
// invio messaggio
function sendMsg(){
    var messaggio = document.getElementById("messageId");
    
    // fai solo se il messaggio non è vuoto
    if(messaggio.value != ""){
        const url = "queries/sendMsg.php";
        sendMsgFetch(messaggio.value, url);
    }
    
    messaggio.value = ""; // svuoto input per invio messaggio
    alwaysType(messaggio); // focus su input per invio messaggio
}
// fetch per invio messaggio
async function sendMsgFetch(messaggio, url){
    await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(messaggio)
    }).catch(err => {
        console.log(err.response.data);
    })
}
// mostra contatti cercati
function searchContact(){
    var a, i, txtValue;
    var input = document.getElementById('searchedId');
    var filter = input.value.toUpperCase();
    var list = document.getElementById("list");
    var contact = list.getElementsByClassName('bg');

    // scorre la lista dei contatti e mostra solo quelli che contengono lettere cercate
    for (i = 0; i < contact.length; i++) {
        a = contact[i].getElementsByClassName("contact")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            contact[i].style.display = "";
        } else {
            contact[i].style.display = "none";
        }
    }
}