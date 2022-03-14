    <div class="container">
    <!-- user section, search, lista contatti -->
    <div class="left" id="left">
        <!-- utente loggato, cambio tema, impostazioni (?), logout -->
        <div class="userSection" id="userSection">
            <div class="wrapper" id="wrapper-user">
                <div class="img">
                    <img src="img/propic/default/default_propic.png" alt="errore">  
                </div>
                <p id="registeredUser">
    
                </p>
                <div class="icons">
                    <button title="Chiaro/Scuro" id="theme-toggle">
                        <i class="fa-solid fa-moon"></i>
                        <i style="padding-right: 3px" class="fa-solid fa-lightbulb"></i>
                    </button>
                    <!-- <button title="Carica immagine profilo" id="upload-propic" onclick="uploadPropic()">
                        <i class="fa-solid fa-image"></i>
                    </button> -->
                    <a title="Logout" href="index.php?scelta=logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- tasto di ricerca chat -->
        <div class="search">
            <div class="form">
                <label for="nameSearched">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </label>
                <input type="text" name="nameSearched" id="searchedId" autocomplete="off" onkeyup="searchContact()" placeholder="Cerca una chat">
            </div>
        </div>
        <!-- lista dei contatti -->
        <div class="list" id="list">
            <!-- lista dei contatti -->
        </div>
    </div>
    <!--  -->
    <div class="right">
        <!-- nome della chat visualizzata -->
        <div class="displayName" id="displayName" >
            <div class="wrapper" id="wrapperDisplay">
                <p>
    
                </p>
            </div>
        </div>
        <!-- chat visualizzata -->
        <div id="box" class="box">
            <!-- se non abbiamo chat visualizzate, mostra questo -->
            <div class="noChat">
                <p>Premi su una chat per iniziare a messaggiare</p>
            </div>
        </div>
        <!-- form per l'invio di messaggi -->
        <div class="send">
            <div class="form" id="sendMsgBox" >
                <input class="send1" type="text" name="message" id="messageId" placeholder="Scrivi un messaggio" autocomplete="off">
                <button class="send2" type="button" id="sendMsg" onclick="sendMsg()">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>  
            </div>
        </div>
    </div>
</div>