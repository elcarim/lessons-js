const 
    board = document.getElementById('board'),
    screens = document.querySelectorAll('.screen'),
    btnStart = document.querySelector('.start'),
    levelList = document.querySelector('.level-list'),
    showLevel = document.getElementById('showLevel'),
    showScore = document.getElementById('showScore'),
    showTime = document.getElementById('showTime'),
    colors = ['#F75C03', '#DA627D', '#648381', '#4DA167', '#5AA3DB', '#DB8B65', '#DB70D2', '#7A46DB']
    
var 
    level = 1,
    gameCounter = 0, //правильных отвветов на текущем уровне
    score = 0,
    time = 60


btnStart.addEventListener('click', (ev) => {
    btnStart.parentNode.classList.add('up') //!!!!
    ev.preventDefault()
})

levelList.addEventListener('click', (ev) => {

    if ( ev.target.classList.contains('level-btn') )
    {
        level = parseInt(ev.target.dataset.level)
        // console.log (level)
        levelList.parentNode.classList.add('up')
        createCircle(level)
        // console.log (ev.target.dataset.level)
    }
    // btnStart.parentNode.classList.add('up')
    // ev.preventDefault()
})
//debug
// createCircle(level)
// screens[0].classList.add('up')
// screens[1].classList.add('up')


function endGame(text) {
    board.innerHTML = `<h2>${text}<br>Очков: ${score}</h3>`

}
function startGame() {
    var intervalId = setInterval(()=>{
        // let current = --time
        if ( --time >= 0 ) {
            showTime.innerHTML = time
        }
        else
        {
            endGame ('Время вышло')
        }

    }, 1000)
    console.log (intervalId)
    showLevel.innerHTML = level
    const circlesList = document.querySelectorAll('.circle')
    circlesList.forEach(circle => {
        circle.addEventListener('click', event => {
            // alert (gameCounter)
            let element = event.target.getAttribute('data-num')
            console.log (':', gameCounter, element)
            if ( gameCounter == element){
                event.target.style.backgroundColor = 'green'
                score = score + level
                showScore.innerText = score

                // if (gameCounter == level) {
                // console.log ('+', gameCounter, element)
                gameCounter++
                if ( level - gameCounter == 0) {
                    console.log ('goood', gameCounter, level)
                    gameCounter = 0
                    level++
                    setTimeout(() => {
                        board.innerHTML = ''
                        createCircle(level)                        
                    }, 500)
                } 

            }else {
                event.target.style.backgroundColor = 'red'
                console.log ('intervalId', intervalId)
                clearInterval(intervalId) //!!!!! почему-то не работает
                // console.log ('-', gameCounter, element)
                setTimeout(() => {
                    endGame ('Проиграл')
                }, 500)                
            }

        })
        
    });
    //!!!!!! не работает если обработчик событий повесить на весь  BOARD . на каждой n итерации происходит N вызовов alert
    // board.addEventListener('click', (event) => {
        // if ( event.target.classList.contains('circle') )
        // {
        //     alert (gameCounter)
        //     let element = event.target.getAttribute('data-num')
        //     console.log (':', gameCounter, element)
        //     if ( gameCounter == element){
        //         event.target.style.backgroundColor = 'green'
        //         showScore.innerText = ++score

        //         // if (gameCounter == level) {
        //         // console.log ('+', gameCounter, element)
        //         gameCounter++
        //         if ( level - gameCounter == 0) {
        //             console.log ('goood', gameCounter, level)
        //             board.innerHTML = ''
        //             level = level + 1
        //             gameCounter = 0
        //             level++
        //             createCircle(level)
        //         } 

        //     }else {
        //         // console.log ('-', gameCounter, element)
        //         // event.target.style.backgroundColor = 'red'
        //     }
            
        // }        
    // })
      
}

function createCircle (i) {
    setTimeout(() => {
        let circle = document.createElement('div')
        circle.classList.add('circle')
        board.append(circle)
        size = Math.round(Math.random() * 50 + 20) 
        circle.style.top = Math.round(Math.random() * (500-size)) + 'px'
        circle.style.left = Math.round(Math.random() * (500-size)) + 'px'
        circle.style.width = `${size}px`
        circle.style.height = `${size}px`
        circle.style.backgroundColor =  colors[Math.round(Math.random() * (colors.length-1))]

        circle.setAttribute('data-num', level - i)

        if ( i > 1) createCircle(--i)
        else startGame()
    }, 500)


}