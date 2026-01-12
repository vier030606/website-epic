<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EPIC NATIONAL Escape Room</title>

    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300;400;900&family=Fredoka:wght@300;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background-image: url('{{ asset('image/background.png') }}');
            background-size: cover;
        }

        #mainContainer {
            position: absolute;
            top: 53%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90vw;
            height: 80vh;
            background-image: url('{{ asset('image/main_panel.png') }}');
            background-size: cover;
            border-radius: 40px;
            backdrop-filter: blur(10px);
            box-shadow:
                inset 0 0 0 4px rgba(255, 255, 255, 0.4),
                0 0 40px rgba(0, 0, 0, 0.8);
        }

        .code-input {
            width: 11vw;
            height: 24vh;
            text-align: center;
            font-family: 'Londrina Solid';
            font-size: 128px;
            border: 4px solid #A19F93;
            border-radius: 25px;
            background-color: white;
            outline: none;
        }

        .code-input.filled {
            border-color: #AF0B0A;
        }

        .search-box {
            width: 23vw;
            background-color: #EFEBD1;
            border: 4px solid #A19F93;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 20px;
            font-family: 'Londrina Solid';
            font-weight: 400;
            letter-spacing: 5px;
            margin-top: 6vh;
            color: #132D40;
        }

        .search-box:focus {
            outline: none;
            box-shadow: none;
        }

        .suggestions-box {
            position: absolute;
            width: 23vw;
            background-color: #EFEBD1;
            border: 4px solid #A19F93;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: none;
            max-height: 20vh;
            overflow-y: auto;
            z-index: 100;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.4) transparent;
            font-family: 'Londrina Solid';
            font-weight: 400;
            letter-spacing: 5px;
            color: #132D40;
        }

        .suggestions-box::-webkit-scrollbar {
            width: 6px;
        }

        .suggestions-box::-webkit-scrollbar-track {
            background: transparent;
        }

        .suggestions-box::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.4);
            border-radius: 15px;
            border: 3px solid transparent;
        }

        .suggestion-item {
            padding: 10px 16px;
            cursor: pointer;
            font-size: 20px;
        }

        .suggestion-item:hover {
            background: #E4D6BD;
        }

        .correct, .false {
            width: 23vw;
            height: 52px;
            border-radius: 10px;
            visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2vh;
        }

        .correct {
            background-color: #15850B;
            border: 4px solid #28FB36;
        }

        .false {
            background-color: #AF0B0A;
            border: 4px solid #FF4900;
        }

        .correct h3, .false h3 {
            width: 100%;
            text-align: center;
            margin : 0;
        }

        #submitBtn {
            width: 17%;
            padding: 15px 0px;
            font-family: 'Fredoka';
            font-size: 36px;
            font-weight: 600;
            background-color: #EFEBD1;
            color: #132D40;
        }

        #submitBtn:hover {
            background-color: #E4D6BD;
        }

        #submitBtn:disabled {
            background-color: #A19F93;
            color: white;
            cursor: not-allowed;
        }

        .code-correct {
            background-color: #28FB36 !important;
        }

        .code-wrong {
            background-color: #AF0B0A !important;
        }
    </style>
</head>

<body>

    <img src="{{ asset('image/EPIC.png') }}" style="position:absolute; top:14%; left:50%; width:20%; transform:translate(-50%,-50%); z-index: 2000;">
    <img src="{{ asset('image/eeyonNembak.png') }}" style="position:absolute; top:86%; left:15%; width:30%; transform:translate(-50%,-50%) scaleX(-1); z-index: 2000;">
    <img src="{{ asset('image/roket.png') }}" style="position:absolute; top:85%; left:97%; width:20%; transform:translate(-50%,-50%); z-index: 2000;">
    <img src="{{ asset('image/eeyonBurger.png') }}" style="position:absolute; top:85%; left:85%; width:55%; transform:translate(-50%,-50%); z-index: 2000;">

    <div id="mainContainer" class="d-flex flex-column align-items-center">

        <img src="{{ asset('image/escapeRoom.png') }}" style="position:absolute; top:7%; width:50%;">

        <div class="d-flex align-items-center justify-content-center gap-5" style="position:absolute; top:28%;">
            <input maxlength="1" class="code-input" id="otp1" autofocus>
            <input maxlength="1" class="code-input" id="otp2">
            <input maxlength="1" class="code-input" id="otp3">
            <input maxlength="1" class="code-input" id="otp4">
            <input maxlength="1" class="code-input" id="otp5">
        </div>

        <div style="position:absolute; top:55%;">
            <input type="text" id="searchInput" class="search-box" placeholder="Loading Team Data..." autocomplete="off">
            <div id="suggestions" class="suggestions-box"></div>
        </div>

        <div class="correct" id="successBox" style="position:absolute; top:69%;">
            <h3 style="color:white; font-family:'Londrina Solid'; letter-spacing:2px; font-size:20px;">Code Verified Successfully!</h3>
        </div>

        <div class="false" id="errorBox" style="position:absolute; top:69%;">
            <h3 style="color:white; font-family:'Londrina Solid'; letter-spacing:2px; font-size:20px;">Incorrect Code. Try Again!</h3>
        </div>

        <button id="submitBtn" class="btn" disabled style="position:absolute; top:83%; border-radius:25px; letter-spacing:5px;" onclick="validateCode()">SUBMIT</button>

    </div>

    <script>
        const API_URL_VALIDATE = '{{ url('/api/validate-code') }}';
        const API_URL_TEAMS = '{{ url('/api/team-names') }}';

        let teamNames = [];
        let teamSelectedValid = false;

        const codeInputs = Array.from(document.querySelectorAll('.code-input'));
        const searchInput = document.getElementById("searchInput");
        const suggestionsBox = document.getElementById("suggestions");

        async function loadTeams() {
            try {
                const response = await fetch(API_URL_TEAMS);

                if (!response.ok) throw new Error("Failed to load team list.");

                teamNames = await response.json();
                searchInput.placeholder = "Search Team";
            } catch (error) {
                console.error(error);
                searchInput.placeholder = "Failed to Load Team";
            }
        }

        codeInputs.forEach((input, index) => {
            input.addEventListener('focus', () => {
                if (index > 0 && codeInputs[index - 1].value === '') {
                    codeInputs[0].focus();
                }
            });

            input.addEventListener('input', (e) => {
                input.value = input.value.toUpperCase().replace(/[^A-Z]/g, '');

                if (input.value) {
                    input.classList.add('filled');
                    if (index < codeInputs.length - 1) {
                        codeInputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }

                updateSubmitState();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace") {
                    e.preventDefault();

                    let lastFilledIndex = codeInputs.length - 1;
                    while (lastFilledIndex >= 0 && codeInputs[lastFilledIndex].value === "") {
                        lastFilledIndex--;
                    }

                    if (lastFilledIndex >= 0) {
                        codeInputs[lastFilledIndex].value = "";
                        codeInputs[lastFilledIndex].classList.remove("filled");
                        codeInputs[lastFilledIndex].focus();
                    }

                    updateSubmitState();
                }
            });
        });

        // AUTOCOMPLETE
        searchInput.addEventListener('input', () => {
            teamSelectedValid = false;

            const query = searchInput.value.trim().toUpperCase();
            suggestionsBox.innerHTML = '';

            if (query.length === 0) {
                suggestionsBox.style.display = 'none';
                updateSubmitState();
                return;
            }

            const filteredTeams = teamNames.filter(name =>
                name.toUpperCase().includes(query)
            );

            if (filteredTeams.length > 0) {
                filteredTeams.slice(0, 5).forEach(team => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.textContent = team;

                    item.addEventListener('click', () => {
                        searchInput.value = team;
                        teamSelectedValid = true;
                        suggestionsBox.style.display = 'none';
                        codeInputs[0].focus();
                        updateSubmitState();
                    });

                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = 'block';
            } else {
                suggestionsBox.style.display = 'none';
            }

            updateSubmitState();
        });

        document.addEventListener('click', (e) => {
            if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
                suggestionsBox.style.display = 'none';
            }
        });

        function highlightPerDigit(userCode, correctCode) {
            for (let i = 0; i < codeInputs.length; i++) {
                const digit = codeInputs[i];
                if (userCode[i] === correctCode[i]) {
                    digit.style.backgroundColor = "#15850B";
                    digit.style.border = "4px solid #28FB36";
                } else {
                    digit.style.backgroundColor = "#AF0B0A";
                    digit.style.border = "4px solid #FF4900";
                }
                digit.style.color = "#FFFFFF";
            }
        }


        async function validateCode() {
            const submitBtn = document.getElementById("submitBtn");
            submitBtn.disabled = true;

            const teamName = searchInput.value.trim();
            const codeInput = codeInputs.map(input => input.value).join('');

            if (!teamSelectedValid || codeInput.length < 5) {
                showError("Pilih tim dari daftar & masukkan kode lengkap!");
                resetInputs();
                return;
            }

            try {
                const response = await fetch(API_URL_VALIDATE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        team_name: teamName,
                        code_input: codeInput
                    })
                });

                const result = await response.json();

                const correctCode = result.correct_code;
                highlightPerDigit(codeInput, correctCode);

                if (response.ok) showSuccess();
                else showError(result.message || "Kode Salah.");
            } catch (error) {
                console.error(error);
                showError("Server Error.");
            } finally {
                setTimeout(() => {
                    resetInputs();
                    hideMessages();
                }, 5000);
            }
        }

        function resetInputs() {
            codeInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled');
                input.style.backgroundColor = "white";
                input.style.color = "#000000";
                input.style.border = "4px solid #A19F93";
            });

            searchInput.value = '';
            teamSelectedValid = false;
            document.getElementById("submitBtn").disabled = true;

            updateSubmitState();
        }

        function showSuccess() {
            document.getElementById("errorBox").style.visibility = "hidden";
            document.getElementById("successBox").style.visibility = "visible";
        }

        function showError(msg) {
            document.getElementById("successBox").style.visibility = "hidden";
            document.getElementById("errorBox").style.visibility = "visible";
        }

        function updateSubmitState() {
            const allFilled = codeInputs.every(input => input.value !== "");
            const submitBtn = document.getElementById("submitBtn");

            submitBtn.disabled = !(allFilled && teamSelectedValid);
        }

        function hideMessages() {
            document.getElementById("successBox").style.visibility = "hidden";
            document.getElementById("errorBox").style.visibility = "hidden";
        }

        document.addEventListener("DOMContentLoaded", loadTeams);
        window.validateCode = validateCode;
    </script>
</body>
</html>