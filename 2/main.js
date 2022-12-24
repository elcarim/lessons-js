const dragBlocks = document.querySelectorAll('.block')
//console.log(dragBlocks)

let  dragleave , dragover, before;
dragBlocks.forEach((dragBlock, i) => {

   

    dragBlock.addEventListener('dragstart', (e) => {
        console.log('dragstart', i)
        // setTimeout(() => e.target.classList.add('hide'), 0)
    
    })

    dragBlock.addEventListener('dragend', (e) => {
        console.log('dragend', i)
        e.target.classList.remove('hide')
        // console.log ( 'dragleave', 'dragBlocks['+i+'].before(dragBlocks['+dragleave+'])') 
        // console.log(dragBlocks[i], dragBlocks[dragleave])

        //пока не знаю как перестроить DOM дерево
        if ( dragleave < i )
            dragBlocks[dragleave].before(dragBlocks[i])
        else 
            dragBlocks[dragleave].after(dragBlocks[i])
    })    
    dragBlock.addEventListener('dragleave', () => {
        
        
        // if ( dragleave < i ) before = true
        // else before = false
        
        // console.log('dragleave', dragleave, i)

        dragleave = i
    })    
    dragBlock.addEventListener('dragover', () => {
        console.log('dragover-->', i, dragleave)
        dragover = i
    })    
})
