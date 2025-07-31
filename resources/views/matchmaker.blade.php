<button onclick="fetchMatch()">Buscar Partida</button>

<div id="popup" style="display:none;">
    <h2 id="popupTitle"></h2>
    <p id="popupDescription"></p>
    <button onclick="joinMatch()">Join</button>
    <button onclick="closePopup()">Cancel</button>
</div>

<script>
    let currentMatch = "";

    function fetchMatch() {
        fetch('/matchmaker?regions=FRA,NY&gamemodes=Free for All,Sharp Shooter&minPlayers=1')
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const match = data[Math.floor(Math.random() * data.length)];
                    currentMatch = match[0];
                    document.getElementById("popupTitle").innerText = "Game Found!";
                    document.getElementById("popupDescription").innerText =
                        `Gamemode: ${match[4].g}, Map: ${match[4].i}, Players: ${match[2]}/${match[3]}`;
                    document.getElementById("popup").style.display = "block";
                } else {
                    alert("No games found.");
                }
            });
    }

    function joinMatch() {
        if (currentMatch) {
            window.location.href = `https://krunker.io/?game=${currentMatch}`;
        }
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>
