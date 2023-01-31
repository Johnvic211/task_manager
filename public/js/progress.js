setTimeout(function(){
    var progress = document.getElementsByClassName('progress-bar')
    console.log(progress.length)

    if(progress.length > 1){
        for(var i = 0; i < progress.length; i++){
            var value = progress[i].ariaValueNow
            if(value > -1 && value < 26)
                progress[i].classList.add('bg-danger')
            else if(value > 25 && value < 51)
                progress[i].classList.add('bg-warning')
            else if(value > 50 && value < 76)
                progress[i].classList.add('bg-info')
            else if(value < 101)
                progress[i].classList.add('bg-success')
        }
    }
}, 600);


