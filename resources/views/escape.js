// Code Input
const inputs = document.querySelectorAll('.code-input');

inputs.forEach((input, index) => {

    // Handle input
    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, ''); // Only numbers

        if (input.value) {
            input.classList.add('filled');

            // Move to next input
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        } else {
            input.classList.remove('filled');
        }

        updateButtonState();
    });

    // Handle backspace
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});


// Team Data
const teamData = [
  {team:"AA",code:"01467"},{team:"AB",code:"02853"},{team:"AC",code:"03214"},
  {team:"AD",code:"04572"},{team:"AE",code:"05689"},{team:"AF",code:"06154"},
  {team:"AG",code:"07238"},{team:"AH",code:"08345"},{team:"AI",code:"09561"},
  {team:"AJ",code:"10429"},{team:"AK",code:"11503"},{team:"AL",code:"12786"},
  {team:"AM",code:"13058"},{team:"AN",code:"14297"},{team:"AO",code:"15304"},
  {team:"AP",code:"16482"},{team:"AQ",code:"17563"},{team:"AR",code:"18695"},
  {team:"AS",code:"19047"},{team:"AT",code:"20318"},{team:"AU",code:"21490"},
  {team:"AV",code:"22534"},{team:"AW",code:"23659"},{team:"AX",code:"24706"},
  {team:"AY",code:"25841"},{team:"AZ",code:"26907"},{team:"BA",code:"27063"},
  {team:"BB",code:"28109"},{team:"BC",code:"29248"},{team:"BD",code:"30476"},
  {team:"BE",code:"31508"},{team:"BF",code:"32691"},{team:"BG",code:"33720"},
  {team:"BH",code:"34816"},{team:"BI",code:"35902"},{team:"BJ",code:"36074"},
  {team:"BK",code:"37158"},{team:"BL",code:"38245"},{team:"BM",code:"39310"},
  {team:"BN",code:"40562"},{team:"BO",code:"41680"},{team:"BP",code:"42795"},
  {team:"BQ",code:"43827"},{team:"BR",code:"44903"},{team:"BS",code:"45069"},
  {team:"BT",code:"46185"},{team:"BU",code:"47201"},{team:"BV",code:"48356"},
  {team:"BW",code:"49423"},{team:"BX",code:"50579"},{team:"BY",code:"51648"},
  {team:"BZ",code:"52731"},{team:"CA",code:"53864"},{team:"CB",code:"54920"},
  {team:"CC",code:"55096"},{team:"CD",code:"56102"},{team:"CE",code:"57218"},
  {team:"CF",code:"58307"},{team:"CG",code:"59481"},{team:"CH",code:"60543"},
  {team:"CI",code:"61675"},{team:"CJ",code:"62709"},{team:"CK",code:"63824"},
  {team:"CL",code:"64912"},{team:"CM",code:"65087"},{team:"CN",code:"66193"},
  {team:"CO",code:"67245"},{team:"CP",code:"68301"},{team:"CQ",code:"69428"},
  {team:"CR",code:"70519"},{team:"CS",code:"71680"},{team:"CT",code:"72764"},
  {team:"CU",code:"73850"},{team:"CV",code:"74932"},{team:"CW",code:"75061"},
  {team:"CX",code:"76125"},{team:"CY",code:"77243"},{team:"CZ",code:"78309"},
  {team:"DA",code:"79456"},{team:"DB",code:"80517"}
];

const teams = teamData.map(item => item.team);

// Search Suggestion
const searchInput = document.getElementById("searchInput");
const suggestionsBox = document.getElementById("suggestions");

searchInput.addEventListener("input", () => {
    const query = searchInput.value.toLowerCase().trim();
    suggestionsBox.innerHTML = "";

    if (query === "") {
        suggestionsBox.style.display = "none";
        updateButtonState();
        return;
    }

    const filtered = teams.filter(team => team.toLowerCase().includes(query));

    if (filtered.length > 0) {
        filtered.forEach(team => {
            const item = document.createElement("div");
            item.textContent = team;
            item.classList.add("suggestion-item");

            item.addEventListener("click", () => {
                searchInput.value = team;
                suggestionsBox.style.display = "none";
                updateButtonState();
            });

            suggestionsBox.appendChild(item);
        });

        suggestionsBox.style.display = "block";
    } else {
        suggestionsBox.style.display = "none";
    }

    updateButtonState();
});


// Button Disable/Enable
const submitBtn = document.getElementById('submitBtn');

function updateButtonState() {
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
    const teamValid = teams.some(team =>
        team.toLowerCase() === searchInput.value.trim().toLowerCase()
    );

    submitBtn.disabled = !(allFilled && teamValid);
}

inputs.forEach(input => input.addEventListener('input', updateButtonState));
searchInput.addEventListener('input', updateButtonState);


// Verify Code
function verifyCode() {
    const enteredCode = Array.from(inputs).map(input => input.value).join("");
    const selectedTeam = searchInput.value.trim().toUpperCase();
    const team = teamData.find(t => t.team === selectedTeam);

    if (!team) return false;
    return team.code === enteredCode;
}


// Button Action
submitBtn.addEventListener('click', () => {

    const correctBox = document.getElementsByClassName("correct")[0];
    const falseBox = document.getElementsByClassName("false")[0];

    if (!verifyCode()) {
        correctBox.style.visibility = "hidden";
        falseBox.style.visibility = "visible";

        inputs.forEach(input => {
            input.value = "";
            input.classList.remove('filled');
        });

        searchInput.value = "";
        inputs[0].focus();
        submitBtn.disabled = true;
        return;
    }

    falseBox.style.visibility = "hidden";
    correctBox.style.visibility = "visible";

    inputs.forEach(input => {
        input.value = "";
        input.classList.remove('filled');
    });

    searchInput.value = "";
    inputs[0].focus();
    submitBtn.disabled = true;
});

// Initialize state
updateButtonState();

submitBtn.addEventListener('click', () => {

    const correctBox = document.getElementsByClassName("correct")[0];
    const falseBox = document.getElementsByClassName("false")[0];

    const enteredCode = Array.from(inputs).map(i => i.value).join("");
    const selectedTeam = searchInput.value.trim().toUpperCase();
    const team = teamData.find(t => t.team === selectedTeam);

    if (!team) return;

    const correctCode = team.code.split(""); // array per digit

    let isCorrect = true;

    inputs.forEach((input, i) => {
        input.classList.remove("code-correct", "code-wrong");

        if (input.value === correctCode[i]) {
            input.classList.add("code-correct");
        } else {
            input.classList.add("code-wrong");
            isCorrect = false;
        }
    });

    if (!isCorrect) {
        correctBox.style.visibility = "hidden";
        falseBox.style.visibility = "visible";

        submitBtn.disabled = true;
        return;
    }

    // Kalau benar semua
    falseBox.style.visibility = "hidden";
    correctBox.style.visibility = "visible";

    submitBtn.disabled = true;
});