<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EPIC NATIONAL Rally</title>

    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300;400;900&family=Fredoka:wght@300;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-space: url('image/background.png');
            --bg-panel: url('image/main_panel.png');
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        /* Pastikan body menggunakan font utama */
        body {
            margin: 0;
            font-family: 'Londrina Solid', cursive; /* Font utama */
            overflow: hidden;
            background: #000;
        }

        /* INPUT dan BUTTON harus dipaksa menggunakan font ini */
        .otp-input, .search-input {
            font-family: 'Londrina Solid', cursive !important;
            font-weight: 400;
        }

        .submit-btn {
            /* Gunakan Fredoka untuk tombol agar lebih tegas */
            font-family: 'Fredoka', sans-serif !important; 
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Jika suggestion box juga hilang fontnya */
        .suggestions {
            font-family: 'Londrina Solid', cursive;
            font-weight: 400;
        }
                

        .app {
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .app::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;

            /* KUNCI UTAMA */
            width: max(1920px, 100vw);
            height: max(1080px, 100vh);

            transform: translate(-50%, -50%);

            background-image: var(--bg-space);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;

            z-index: -1;
        }

        .logo {
            position: absolute;
            top: 0vh;
            left: 50%;
            transform: translateX(-50%);
            width: clamp(160px, 25vw, 260px);
            z-index: 10;
        }

        .logo {
            max-width: 55vw;
        }

        .panel {
            height: 85vh;
            width: 90vw;
            background: var(--bg-panel) center / cover no-repeat;
            border-radius: 32px;
            margin-top: 8vh;
            display: flex;
            flex-direction: column;
            align-items: center;

            box-shadow:
                inset 0 0 0 4px rgba(255, 255, 255, 0.4),
                0 0 40px rgba(0, 0, 0, 0.8);
            
                overflow: visible !important;
        }

        .panel {
            padding-inline: clamp(12px, 3vw, 32px);
        }

        .scoreboard { 
            margin-top: 7vh; 
            width: 60%; 
            max-width: 500px;
        }

        .otp { 
            display: flex; 
            gap: 12px; 
            margin-top: 2vh; }

        .otp-input {
            width: clamp(8vw, 10vw, 11vw); 
            height: clamp(7vw, 10vw, 11vw); 
            font-size: clamp(32px, 8vw, 72px); 
            text-align: center;
            border-radius: 16px; 
            border: 4px solid #A19F93; 
            background: #FFFFFF; 
            outline: none;
            font-family : 'Londrina Solid'
        }

        .otp-input.filled { 
            border-color: #AF0B0A; }

        /* --- LAYOUT BARU: SEARCH DI ATAS, NOTIF DI BAWAH --- */
        .search-wrapper {
            position: relative; 
            width: min(90%, 380px); 
            margin-top: 3vh; display: flex; 
            flex-direction: column;
        }

        .search-input {
            width: 100%; 
            padding: 10px 16px; 
            border-radius: 10px; 
            border: 4px solid #A19F93;
            background: #EFEBD1; 
            font-size: 18px; 
            letter-spacing: 3px; 
            color: #132D40; 
            z-index: 5;
        }

        .suggestions {
            position: absolute; 
            top: 55px; left: 0; 
            width: 100%; 
            background: #EFEBD1;
            border: 4px solid #A19F93; 
            border-radius: 10px; 
            max-height: 150px; 
            overflow-y: auto;
            display: none; 
            z-index: 9999; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .notification-area {
            position: relative; 
            width: 100%; height: 55px; 
            margin-top: 10px;
        }

        .feedback {
            position: absolute; 
            top: 0; left: 0; 
            width: 100%; 
            display: none; /* Pakai display none agar bertumpuk */
            text-align: center; 
            padding: 8px; 
            border-radius: 10px; 
            font-size: 16px; 
            color: white;
        }

        .feedback.success { 
            background: #15850B; 
            border: 3px solid #28FB36; 
        
        }
        .feedback.error { 
            background: #AF0B0A; 
            border: 3px solid #FF4900; 
        }

        .submit-btn {
            width: min(90%, 380px); 
            height: 8vh; 
            padding: 12px 0; 
            margin-top: 12vh;
            font-family: 'Fredoka', sans-serif; 
            font-size: clamp(20px, 4vw, 32px);
            font-weight: 600; 
            background: #EFEBD1; 
            color: #132D40; 
            border-radius: 24px;
            display: flex; 
            justify-content: center; 
            align-items: center;
        }

        .submit-btn:hover {
            background-color: #E4D6BD;
        }

        .submit-btn:disabled {
            background-color: #A19F93;
            color: white;
            cursor: not-allowed;
        }

        /* Responsive adjustments as per your original code */


        @media (max-width: 768px) and (max-height: 1024px) {
            .panel {
                width: 96vw;
                height: 90vh;
                /* background-color: red; */
                margin-top: 4vh;
            }

            .logo {
                min-width: 150px;
                max-width: 40vw;
                margin-top: 1vh;
            }
            .search-wrapper { 
                margin-top: 4vh;
                width: 50%; 
            }
            .otp {
                margin-top: 4vh;
            }
            .otp-input { 
                width: 14vw; 
                height: 14vw; 
            }

            .search-wrapper {
                margin-top: 8vh
            }

            .submit-btn {
                margin-top: 16vh;
            }
        }
        @media (max-width: 1024px) {
            .panel {
                width: 94vw;
                height: 88vh;
                /* background-color: #000000; */
            }

            .logo {
                margin-top: 2vh;
                max-width: 25vw;
            }
            .search-wrapper { 
                margin-top: 5vh;
                width: 60%; 
            }
            .otp {
                margin-top: 4vh;
            }
            .otp-input { 
                width: clamp(10vw, 14vw, 16vw); 
                height: clamp(10vw, 14vw, 16vw); 
            }

            .search-wrapper {
                margin-top: 6vh;
                width: 60%;
            }

            .submit-btn {
                width: 30%;
                margin-top: 12vh;
            }
        }

        @media (max-width: 480px) {
            .logo {
                width: 25vw;
                margin-top: 1vh;
            }

            .scoreboard {
                width: 80%;
                margin-top: 8vh;
            }

            .panel {
                width: 95vw;
                height: 90vh;
                border-radius: 20px;
                /* background-color: pink; */
            }

            .otp {
                margin-top: 6vh;
                gap: 8px;
            }

            .otp-input {
                width: 14vw;
                height: 18vw;
            }

            .search-wrapper {
                margin-top: 10vh;
                width: 70%;
            }

            .search-input {
                font-size: 16px;
                height: 7vh;
            }

            .submit-btn {
                width: 60vw;
                margin-top: 6vh;
            }

        }

        @media (max-width: 768px) {
            .panel {
                width: 96vw;
                height: 90vh;
                margin-top: 6vh;
                /* background-color: blue; */
            }

            .logo {
                min-width: 150px;
                max-width: 40vw;
                margin-top: 1vh;
            }
        }

        @media (max-height: 646px) and (max-width: 1025px){
            .panel {
                /* background-color: purple; */
            }
            .logo {
                max-width: clamp(10vw, 15vw, 20vw);
            }

            .scoreboard {
                width: 40%;
            }

            .otp-input {
                width: 10vw;
                height: 10vw;
            }

            .search-wrapper {
                width: 30%;
            }
            
            .search-input {
                height: 8vh;
            }

            .submit-btn {
                width: 30%;
                margin-top: 4vh;
            }
        }

        @media (max-height: 1369px) {
            .panel {
                margin-top: 4vh;
                height: 90vh;
                /* background-color: yellow; */
            }

            .scoreboard {
                margin-top: 8vh;
            }
        }

        @media (max-height: 601px) and (max-width: 1025px) {
            .panel {
                margin-top: 8vh;
                height: 88vh;
                /* background-color: orange; */
            }

            .logo {
                margin-top: -1vh;
            }
        }

        @media (max-width: 1280px) and (max-height: 800px) {
            .panel {
                margin-top: 10vh;
                height: 85vh;
                /* background-color: brown; */
            }

            .otp-input {
                width: 16vw;
                height: 15vw;
            }
            
            .logo {
                min-width: 170px;
                margin-top: 1vh;
            }

            .scoreboard {
                margin-top: 10vh;
            }

            .search-wrapper {
                margin-top: 6vh;
            }

        }

        @media (max-height: 646px) and (max-width: 1025px){
                .panel {
                    margin-top: 6vh;
                    height: 90vh;
                    /* background-color: orange; */
                }

                .logo {
                    margin-top: -1vh;
                }
        }

        /* @media (max-height: 1080px) and (max-width: 1920px){
        .panel {
            margin-top: 6vh;
            height: 90vh;
            background-color: green;
        }

        .logo {
            margin-top: -1vh;
            width: 18vw;
        }
    } */

        @media (max-height: 668px) and (max-width: 376px){

        .panel {
            width: 94vw;
            height: 88vh;
            /* background-color: blue; */
        }

        .logo {
            margin-top: 0px;
            width: 20vw;
        }
}

@media (max-height: 860px) and (max-width: 1440px){
        .panel {
            margin-top: 6vh;
            height: 90vh;
            /* background-color: green; */
        }

        .logo {
            width: 18vw;
        }
}

@media (max-height: 844px) and (max-width: 541px){

        .panel {
            width: 94vw;
            height: 88vh;
            /* background-color: brown; */
        }

        .logo {
            margin-top: 2vh;
            width: 20vw;
        }
}



    </style>
</head>
<body>
    <div class="app">
        <img src="image/EPIC.png" class="logo">
        <div id="mainContainer" class="panel">
            <img src="image/scoreboard.png" class="scoreboard">

            <div class="otp">
                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input" autofocus>
                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input">
                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input">
                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input">
                <input maxlength="1" inputmode="numeric" pattern="[0-9]*" class="otp-input">
            </div>

            <div class="search-wrapper">
                <input type="text" class="search-input" placeholder="SEARCH TEAM">
                
                <div class="suggestions" id="suggestionBox"></div>

                <div class="notification-area">
                    <div class="feedback error" id="errorBox">Incorrect Code. Try Again!</div>
                    <div class="feedback success" id="successBox">Code Verified Successfully!</div>
                </div>
            </div>

            <button class="btn submit-btn">SUBMIT</button>
        </div>
    </div>

    <script>
        const API_URL_VALIDATE = '{{ url("/api/rally-validate") }}';
        const API_URL_TEAMS = '{{ url("/api/rally-teams") }}';

        const otpInputs = Array.from(document.querySelectorAll('.otp-input'));
        const searchInput = document.querySelector('.search-input');
        const suggestionsBox = document.getElementById('suggestionBox');
        const submitBtn = document.querySelector('.submit-btn');
        const successBox = document.getElementById('successBox');
        const errorBox = document.getElementById('errorBox');

        let teamNames = @json($teamNames);
        let isTeamValid = false;

        // async function fetchTeams() {
        //     try {
        //         const response = await fetch(API_URL_TEAMS);
        //         teamNames = await response.json();
        //     } catch (error) { console.error("Load failed", error); }
        // }

        function showFeedback(type) {
            successBox.style.display = 'none';
            errorBox.style.display = 'none';
            if (type === 'success') successBox.style.display = 'block';
            if (type === 'error') errorBox.style.display = 'block';
        }

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Hapus warna error/sukses saat user mulai mengetik lagi
                input.style.borderColor = ""; 
                input.style.backgroundColor = "";
                input.style.color = "";
                
                // FILTER: Hanya terima angka 0-9
                input.value = input.value.replace(/[^0-9]/g, ''); 
                
                showFeedback('none');

                if (input.value) {
                    input.classList.add('filled');
                    // Auto focus ke kotak berikutnya
                    if (index < otpInputs.length - 1) otpInputs[index + 1].focus();
                } else {
                    input.classList.remove('filled');
                }
                checkFormValidity();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim().toUpperCase();
        suggestionsBox.innerHTML = '';
        isTeamValid = false;
        showFeedback('none');

        if (!query) {
            suggestionsBox.style.display = 'none';
            return;
        }

        // The logic remains the same, but it uses the pre-loaded teamNames array
        const filtered = teamNames.filter(name => name.toUpperCase().includes(query));
        if (filtered.length > 0) {
            filtered.slice(0, 5).forEach(team => {
                const item = document.createElement('div');
                item.className = 'suggestion-item';
                item.style.padding = '10px';
                item.style.cursor = 'pointer';
                item.textContent = team;
                item.onclick = () => {
                    searchInput.value = team;
                    isTeamValid = true;
                    suggestionsBox.style.display = 'none';
                    otpInputs[0].focus();
                    checkFormValidity();
                };
                suggestionsBox.appendChild(item);
            });
            suggestionsBox.style.display = 'block';
        } else {
            suggestionsBox.style.display = 'none';
        }
        checkFormValidity();
    });

        function checkFormValidity() {
            const isOtpFilled = otpInputs.every(input => input.value.length === 1);
            submitBtn.disabled = !(isOtpFilled && isTeamValid);
        }


        submitBtn.addEventListener('click', async () => {
            const teamName = searchInput.value;
            const code = otpInputs.map(i => i.value).join('');

            submitBtn.disabled = true;

            try {
                const response = await fetch(API_URL_VALIDATE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ team_name: teamName, code_input: code })
                });

                const result = await response.json();

                if (response.ok) {
                    // ... (kode warna hijau dan feedback sukses) ...

                    // GANTI window.location.href DENGAN KODE DI BAWAH:
                    
                    // 1. Buat form secara dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/scoreboard') }}`;

                    // 2. Tambahkan CSRF Token (Wajib di Laravel POST)
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrfInput);

                    // 3. Tambahkan data Team
                    const teamInput = document.createElement('input');
                    teamInput.type = 'hidden';
                    teamInput.name = 'team';
                    teamInput.value = teamName;
                    form.appendChild(teamInput);

                    // 4. Masukkan ke dokumen dan submit
                    document.body.appendChild(form);
                    form.submit();
                    
                } else {
                    // LANGSUNG MERAH
                    otpInputs.forEach((input) => {
                        input.style.borderColor = "#FF4900";     
                        input.style.backgroundColor = "#AF0B0A"; 
                        input.style.color = "#FFFFFF";
                    });
                    showFeedback('error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = "SUBMIT";
                }
            } catch (error) {
                alert("Connection Error!");
                submitBtn.disabled = false;
                submitBtn.textContent = "SUBMIT";
            }
        });

        document.addEventListener('DOMContentLoaded', fetchTeams);
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target)) suggestionsBox.style.display = 'none';
        });

        async function fetchTeams() {
            try {
                const response = await fetch(API_URL_TEAMS);
                teamNames = await response.json();
                console.log("Teams Loaded:", teamNames); // Cek di F12 (Console)
            } catch (error) { 
                console.error("Load failed", error); 
            }
        }
    </script>
</body>
</html>