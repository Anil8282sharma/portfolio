<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic-Tac-Toe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #333;
        }

        #nameEntry {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #nameEntry input {
            font-size: 1.2em;
            padding: 10px;
            margin: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 80%;
            max-width: 300px;
        }

        #nameEntry input:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        #nameEntry button {
            font-size: 1.2em;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #nameEntry button:hover {
            background-color: #0056b3;
        }

        #countdown {
            font-size: 2em;
            animation: countdownAnimation 3s linear forwards;
        }

        .hidden {
            display: none;
        }

        #board {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-gap: 10px;
            margin: 20px auto;
        }

        .cell {
            width: 100px;
            height: 100px;
            background-color: #fff;
            border: 2px solid #000;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cell:hover {
            background-color: #f1f1f1;
        }

        @keyframes countdownAnimation {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

        #winner {
            font-size: 2em;
            color: green;
            animation: winnerAnimation 1s infinite;
        }

        @keyframes winnerAnimation {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tic-Tac-Toe</h1>
        <div id="nameEntry">
            <input type="text" id="player1" placeholder="Enter Player 1 Name" onfocus="handleFocus(this)" onblur="handleBlur(this)">
            <input type="text" id="player2" placeholder="Enter Player 2 Name" onfocus="handleFocus(this)" onblur="handleBlur(this)">
            <button onclick="startGame()">Start Game</button>
        </div>
        <div id="countdown" class="hidden">3</div>
        <div id="game" class="hidden">
            <div id="playerInfo"></div>
            <div id="board">
                <div class="cell" data-index="0"></div>
                <div class="cell" data-index="1"></div>
                <div class="cell" data-index="2"></div>
                <div class="cell" data-index="3"></div>
                <div class="cell" data-index="4"></div>
                <div class="cell" data-index="5"></div>
                <div class="cell" data-index="6"></div>
                <div class="cell" data-index="7"></div>
                <div class="cell" data-index="8"></div>
            </div>
        </div>
        <div id="winner" class="hidden"></div>
    </div>
    <script>
        let currentPlayer = 'X';
        let board = ['', '', '', '', '', '', '', '', ''];
        let player1Name, player2Name;

        function handleFocus(input) {
            input.style.borderColor = '#007BFF';
            input.style.boxShadow = '0 0 5px rgba(0, 123, 255, 0.5)';
        }

        function handleBlur(input) {
            input.style.borderColor = '#ddd';
            input.style.boxShadow = 'none';
        }

        function startGame() {
            player1Name = document.getElementById('player1').value;
            player2Name = document.getElementById('player2').value;

            if (!player1Name || !player2Name) {
                alert('Please enter both player names.');
                return;
            }

            document.getElementById('nameEntry').classList.add('hidden');
            startCountdown();
        }

        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            countdownElement.classList.remove('hidden');

            let count = 3;
            countdownElement.innerHTML = count;

            const interval = setInterval(() => {
                count--;
                if (count === 0) {
                    clearInterval(interval);
                    countdownElement.classList.add('hidden');
                    startPlaying();
                } else {
                    countdownElement.innerHTML = count;
                }
            }, 1000);
        }

        function startPlaying() {
            document.getElementById('game').classList.remove('hidden');
            updatePlayerInfo();
            document.querySelectorAll('.cell').forEach(cell => {
                cell.addEventListener('click', handleCellClick);
            });
        }

        function handleCellClick(event) {
            const cell = event.target;
            const index = cell.getAttribute('data-index');

            if (board[index] !== '') return;

            board[index] = currentPlayer;
            cell.innerHTML = currentPlayer;

            if (checkWin()) {
                declareWinner();
                return;
            }

            if (board.every(cell => cell !== '')) {
                declareDraw();
                return;
            }

            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            updatePlayerInfo();
        }

        function updatePlayerInfo() {
            const playerInfo = document.getElementById('playerInfo');
            playerInfo.innerHTML = `Current Player: ${currentPlayer === 'X' ? player1Name : player2Name}`;
        }

        function checkWin() {
            const winPatterns = [
                [0, 1, 2], [3, 4, 5], [6, 7, 8],
                [0, 3, 6], [1, 4, 7], [2, 5, 8],
                [0, 4, 8], [2, 4, 6]
            ];

            return winPatterns.some(pattern => {
                return pattern.every(index => board[index] === currentPlayer);
            });
        }

        function declareWinner() {
            document.getElementById('game').classList.add('hidden');
            const winner = currentPlayer === 'X' ? player1Name : player2Name;
            const winnerElement = document.getElementById('winner');
            winnerElement.innerHTML = `Hurray! ${winner} Wins! 🎉`;
            winnerElement.classList.remove('hidden');
            showConfetti();
            saveWinner(winner);
        }

        function declareDraw() {
            document.getElementById('game').classList.add('hidden');
            const winnerElement = document.getElementById('winner');
            winnerElement.innerHTML = `It's a Draw! 🤝`;
            winnerElement.classList.remove('hidden');
            showConfetti();
            saveWinner('Draw');
        }

        function showConfetti() {
            // Confetti animation (You can use a confetti library for more effect)
            const confettiElement = document.createElement('div');
            confettiElement.className = 'confetti';
            document.body.appendChild(confettiElement);
            setTimeout(() => confettiElement.remove(), 3000);
        }

        function saveWinner(winner) {
            fetch('save_score.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `winner=${winner}`
            })
            .then(response => response.text())
            .then(data => console.log(data));
        }
    </script>
</body>
</html>
