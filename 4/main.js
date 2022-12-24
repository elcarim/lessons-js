const container = document.querySelector('.container')
const board = document.querySelector('#board')

const btns = document.querySelectorAll('.btn')
var sizeboard = 20 //поумолчанию
var sqrs 

btns.forEach( btn => {
    btn.addEventListener('click', (ev) => {
        let sizeboard = ev.target.dataset.size
        console.log (sizeboard)
        
        sqrs = createBoard ( sizeboard )
    })
});

function randomColor() {
    return '#'
        + (Math.round(Math.random() * 255)).toString(16)
        + (Math.round(Math.random() * 255)).toString(16)
        + (Math.round(Math.random() * 255)).toString(16)

}

function createBoard ( sizeboard) {
    board.innerHTML = ''
    container.style.width = sizeboard*20 + 'px'
    for (let i=1; i<=sizeboard*sizeboard; i++)
    {
        const sqr = document.createElement('div')
        sqr.classList.add('sqr')
    
        board.append(sqr)
    }


    // container.addEventListener('click', ev => {
    //     if (ev.target.classList.contains('sqr')) {
    //         console.log (ev.target)
    //     }
    // })

    sqrs = document.querySelectorAll('.sqr')
    sqrs.forEach((sqr, index)=> {
        sqr.addEventListener('click', (ev) => { // mouseover
            let color = randomColor()
            sqr.style.backgroundColor = color
            sqr.style.borderRadius = '100%'
            
            setTimeout (() => {
                sqr.style.backgroundColor = ``
                sqr.style.borderRadius = ''
            }, 300)
            dropDown ( index, color )
        })
    })
   
}

createBoard ( sizeboard);

function dropDown ( index, color )
{
    console.log (index)
    if ( index < (sizeboard-1)*20 )
        setTimeout (() => {
            index += sizeboard
            console.log (index)
            sqrs[index].style.borderRadius = '100%'
            sqrs[index].style.backgroundColor = color
            setTimeout (() => {
                sqrs[index].style.backgroundColor = ''
                sqrs[index].style.borderRadius = ''
            }, 300)
            dropDown (index, color);

        
            }, 50)

}



