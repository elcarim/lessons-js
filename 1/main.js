const blocks = document.querySelectorAll('.block')

blocks.forEach((block, i) => {
    block.addEventListener("click", () => {
        // document.querySelector('.block.active').classList.remove('active')
        const blocksActive = document.querySelectorAll('.block.active')
        blocksActive.forEach((blockActive) => {
            blockActive.classList.remove('active') 
        })
        block.classList.add('active')
        console.log ('add' + i)

        document.body.style.backgroundColor = 'rgb(0 255 0  /' + (100 - 20*(5-i))+ '%)';
        
    }) 
})
