<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EPIC NATIONAL Escape Room</title>

    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300;400;900&family=Fredoka:wght@300;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
    /* BACKGROUNDS */
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

/* body {
    margin: 0;
    font-family: 'Londrina Solid', cursive;
    background: var(--bg-space) center / cover no-repeat;
    overflow: hidden;
} */

body {
    margin: 0;
    font-family: 'Londrina Solid', cursive;
    overflow: hidden;
    background: #000;
}

/* 
.app {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    padding: 16px;
} */

/* .app {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    padding: 24px 8px
} */

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
    max-width: 45vw;
}

.scoreboard {
    width: 70%;
    max-width: 600px;
}


/* .panel {
    width: min(95vw, 900px);
    min-height: 80vh;

    background: var(--bg-panel) center / cover no-repeat;
    border-radius: 32px;

    padding: 120px 24px 32px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;

    box-shadow:
        inset 0 0 0 4px rgba(255, 255, 255, 0.4),
        0 0 40px rgba(0, 0, 0, 0.8);
} */

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
}

.name-cont {
    font-family: 'Orbitron';
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    margin-top: 10vh;
}

.name-cont h1 {
    font-size: 90px;
    font-weight: 800;
    text-shadow: 
        0 0 10px #ffffff,        /* Core glow */
        0 0 20px #ffffff,        /* Solid glow */
        0 0 40px rgba(255, 255, 255, 0.8), 
        0 0 60px rgba(255, 255, 255, 0.5),
        0 0 80px rgba(255, 255, 255, 0.3);
}


.score-cont {
    /* Transisi halus saat border berubah warna */
    transition: border-color 0.5s ease;
    
    /* Properti lainnya tetap sama */
    width: clamp(25vw, 30vw, 420px);
    height: clamp(140px, 28vh, 260px);
    border-radius: 16px;
    border: 4px solid #A19F93; /* Warna default jika style inline gagal */
    background: #FFFFFF;
    display: flex;
    justify-content: center;
    align-items: center;
}

.score-main {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 5vw;
}

.score {
    display: flex;
    flex-direction: column;
    gap: 2vh;
    align-items: center;
    font-family: 'Fredoka';
}

.score h3 {
    font-size: 55px;
    font-weight: bolder;
    /* -webkit-text-stroke: 1px #ffffff; */
text-shadow: 
        1px  1px 0 #fff,
       -1px  1px 0 #fff,
        1px -1px 0 #fff,
       -1px -1px 0 #fff,
        1px  0px 0 #fff,
       -1px  0px 0 #fff,
        0px  1px 0 #fff,
        0px -1px 0 #fff;
}

/* .score-cont {
    width: 30vw;
    height: 30vh;
    border-radius: 16px;
    border: 4px solid #A19F93;
    background: #FFFFFF;
    outline: none;
} */


.panel {
    padding-inline: clamp(12px, 3vw, 32px);
}

.name-cont {
    margin-top: clamp(6vh, 8vh, 10vh);
    text-align: center;
}

.name-cont h1 {
    font-size: clamp(32px, 6vw, 80px);
}

.name-cont h3 {
    font-size: clamp(20px, 4vw, 50px);
}

.score-main {
    margin-top: clamp(3vh, 5vh, vh);
}

.score h3 {
    font-size: clamp(24px, 4vw, 55px);
}

.score-cont {
    width: clamp(25vw, 30vw, 420px);
    height: clamp(140px, 28vh, 260px);
    font-family: 'Fredoka';
    display: flex;
    justify-content: center;
    align-items: center;
}

.score-cont h3 {
    font-size: clamp(48px, 10vw, 120px);
    letter-spacing: 10px;
}

@media (max-width: 768px) and (max-height: 1024px) {

    .panel {
        width: 94vw;
        height: 88vh;
        /* background-color: blue; */
    }

    .logo {
        margin-top: -10px;
        width: 20vw;
    }

    .score-main {
        gap: 4vw;
        flex-direction: column;
    }

    .score-cont {
            width: 70vw;           
            height: 18vh;
    }       

    .score h3 {
        font-size: clamp(20px, 4vw, 32px);
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

    .name-cont {
        margin-top: 10vh;
    }

    .score-main {
        gap: 4vw;
        flex-direction: row;
        margin-top: 3vh
    }

    .score-cont {
        width: 35vw;           
        height: 25vh;
    }       

    .score h3 {
        font-size: clamp(20px, 5vw, 46px);
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

    .score-main {
        flex-direction: column;
        gap: 4vh;
    }

    .score-cont {
        width: 74vw;
        height: 15vh;
    }
}

/* @media (max-width: 1025px) and (max-height: 1367px) {
        .score-main {
            flex-direction: row;
            gap: 3vh; 
        }

        .score-cont {
            width: 40vw;           
            height: 25vh;     

        .score h3 {
            font-size: clamp(20px, 4vw, 32px);
        }
    } */

@media (max-width: 480px) {
    .panel {
        width: 95vw;
        height: 90vh;
        border-radius: 20px;
        /* background-color: red; */
    }

    .logo {
        width: 25vw;
        margin-top: 1vh;
    }

    .name-cont {
        margin-top: 6vh;
    }

    .score h3 {
        font-size: 28px;
    }

    .score-main {
        flex-direction: column;
    }

    .score-cont {
        width: 88vw;
        height: 20vh;
        border-radius: 12px;
    }

    .score-cont h3 {
        font-size: 40px;
    }

}

    @media (max-height: 1369px){
        .panel {
            margin-top: 4vh;
            height: 90vh;
            /* background-color: purple; */
        }

        .name-cont {
            margin-top: 8vh;
        }

        .score-main {
            margin-top: 6vh;
            flex-direction: column;
        }
        .score-cont {
            width: 80vw;           
            height: 20vh;
        }

        .score-cont h3 {
            font-size: clamp(40px, 10vw, 80px);
        }
    }

    @media (max-height: 601px) and (max-width: 1025px){
        .panel {
            margin-top: 8vh;
            height: 88vh;
            /* background-color: pink; */
        }

        .logo {
            margin-top: -1vh;
        }

        .name-cont {
            margin-top: 12vh;
        }

        .name-cont h1 {
            font-size: 4vw
        }

        .name-cont h3 {
            font-size: 3vw
        }

        .score-main {
            margin-top: 5vh;
            flex-direction: row;
        }
        .score-cont {
            width: 40vw;           
            height: 30vh;
        }

        .score-cont h3 {
            font-size: clamp(32px, 10vw, 72px);
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

        .name-cont {
            margin-top: 7vh;
        }

        .name-cont h1 {
            font-size: 5vw
        }

        .score-main {
            margin-top: 4vh;
            flex-direction: column;
        }
        .score-cont {
            width: 80vw;           
            height: 16vh;
        }

        .score-cont h3 {
            font-size: clamp(28px, 10vw, 60px);
        }
    }

    @media (max-height: 860px) and (max-width: 1536px){
        .panel {
            margin-top: 6vh;
            height: 90vh;
            /* background-color: green; */
        }

        .logo {
            width: 18vw;
        }

        .name-cont {
            margin-top: 12vh;
        }

        .name-cont h1 {
            font-size: 4vw
        }

        .score-main {
            margin-top: 4vh;
            flex-direction: row;
        }
        .score-cont {
            width: 38vw;           
            height: 28vh;
        }

        .score-cont h3 {
            font-size: clamp(28px, 10vw, 60px);
        }
    }

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

        .name-cont {
            margin-top: 6vh;
        }

        .name-cont h1 {
            font-size: 12vw
        }

        .name-cont h3 {
            font-size: 8vw
        }

        .score-main {
            gap: 4vw;
            flex-direction: column;
        }

        .score-cont {
            width: 70vw;           
            height: 18vh;
        }       

        .score h3 {
            font-size: clamp(20px, 4vw, 32px);
        }

        .score-cont h3 {
            font-size: clamp(32px, 10vw, 60px);
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

        .name-cont {
            margin-top: 6vh;
        }

        .name-cont h1 {
            font-size: 10vw
        }

        .name-cont h3 {
            font-size: 6vw
        }

        .score-main {
            gap: 4vw;
            flex-direction: column;
        }

        .score-cont {
            width: 70vw;           
            height: 18vh;
        }       

        .score h3 {
            font-size: clamp(24px, 6vw, 36px);
        }

        .score-cont h3 {
            font-size: clamp(32px, 10vw, 60px);
        }
    }


    /* @media (max-height: 864px) {
        .panel {
            background-color: yellow;
        .score-main {
            gap: 8vw;
            flex-direction: row;
        }
    } */

    @media (min-aspect-ratio: 16/9) {
        .panel {
            /* background-color: purple; */
        }

        .name-cont {
            margin-top: 15vh;
        }

        .score-main {
            gap: 8vw;
            flex-direction: row;
        }

        .score-cont {
            width: 35vw;           
            height: 30vh;
        }
    }

    @media screen and (max-aspect-ratio: 4/3) {
        .body {
            margin: 0;
        }
        .panel {
            margin-top: 4vh;
            height: 90vh;
            /* background-color: pink; */
        }

        .logo {
            margin-top: 2vh;
        }

        .name-cont {
            margin-top: 8vh;
        }

        .name-cont h1 {
            font-size: 8vw
        }

        .name-cont h3 {
            font-size: 5vw
        }
        .score-main {
            margin-top: 6vh;
            gap: 4vw;
            flex-direction: column;
        }

        .score-cont {
            width: 70vw;           
            height: 18vh;
            border-radius: 16px;
        }       
    }


    </style>
</head>
<body>
    <div class="app">

        <img src="image/EPIC.png"
             class="logo">

        <div id="mainContainer" class="panel">
            @php
                $valRally = $result->{'POIN RALLYgi'} ?? 0;
                $currentScore = (int) filter_var($valRally, FILTER_SANITIZE_NUMBER_INT);

                if($currentScore >= 90) {
                    $lvlColor = "#7DE05C";
                    $lvlText  = "Level 3";
                } elseif($currentScore >= 40) {
                    $lvlColor = "#FFD739"; 
                    $lvlText  = "Level 2";
                } else {
                    $lvlColor = "#ff5453";
                    $lvlText  = "Level 1";
                }
            @endphp

            <div class="name-cont">
                <h1 class="team-display">{{ $teamName }}</h1>
                <h3 style="color: {{ $lvlColor }}; 
                    text-shadow: 
                        0 0 10px {{ $lvlColor }}, 
                        0 0 20px {{ $lvlColor }}, 
                        0 0 40px {{ $lvlColor }}, 
                        0 0 60px {{ $lvlColor }};
                    font-weight: 800;
                    transition: all 0.5s ease;">
                    {{ $lvlText }}
                </h3>
            </div>

            <div class="score-main">
                <div class="score">
                    <h3>ECT Rally</h3>
                    <!-- {{-- Border box ikut berubah sesuai warna level --}} -->
                    <div class="score-cont" style="border-color: {{ $lvlColor }};">
                        <h3>{{ $result->{'POIN RALLY'} ?? '0' }}</h3>
                    </div>
                </div>

                <div class="score">
                    <h3>ECT Total</h3>
                    <div class="score-cont" style="border-color: {{ $lvlColor }};">
                        <h3>{{ $result->{'RALLY TOTAL'} ?? '0' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
