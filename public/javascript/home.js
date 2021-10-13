// CAROUSEL SLIDER SCRIPT

const carouselSliderContainer =  document.getElementsByClassName('carousel-slider-container');


const bind = (container) => {
    const nextBtn = container.getElementsByClassName('carousel-next')[0];
    const prevBtn = container.getElementsByClassName('carousel-prev')[0];
    const contentContainer = container.getElementsByClassName("carousel-content-container")[0];
    const slider = container.getElementsByClassName("carousel-content")[0];
    const items = container.getElementsByClassName('item');

    let clicks = 0;
    let clicksLimit = 4;

    const resizeItem  = (n) => {
        for (let i = 0; i < items.length; i++) {
            let item = items[i];
            item.style.width = `${contentContainer.clientWidth / n}px`;
        }   
    }
    
    const getScreenRange = () => {
        if(window.innerWidth > 1120){
            return 'A';
        }else if(window.innerWidth > 675 && window.innerWidth <= 1120){
            return 'B';
        }else if(window.innerWidth > 320 && window.innerWidth <= 675){
            return 'C';
        }else{
            return 'D';
        }
    }
    
    const getItemSize = () => {
        let screenSize =  getScreenRange();
        switch(screenSize){
            case 'A':
                return contentContainer.clientWidth / 4;
                break;
            case 'B':
                return contentContainer.clientWidth / 3;
                break;
            case 'C':
                return contentContainer.clientWidth / 2;
                break;
            case 'D':
                return contentContainer.clientWidth / 1;
                break;
        }
    }
    
    
    window.addEventListener('load', () => {
    
       switch(getScreenRange()){
           case 'A': 
                resizeItem(4)
                clicksLimit = 4;
                break;
            case 'B':
                resizeItem(3)
                clicksLimit = 5;
                break;
            case 'C':
                resizeItem(2)
                clicksLimit = 6;
                break;
            case 'D':
                resizeItem(1)
                clicksLimit = 7;
                break;
       }
    })
    
    
    window.addEventListener('resize', () => {
    
        setInterval(() => {
        slider.style.transform = `translateX(-${getItemSize() * clicks}px)`;
    
        switch(getScreenRange()){
            case 'A': 
                resizeItem(4);
                clicksLimit = 4;     
                break;
            case 'B':
                resizeItem(3)
                clicksLimit = 5;  
                break;
            case 'C':
                resizeItem(2)
                clicksLimit = 6;
                break;
            case 'D':
                resizeItem(1);
                clicksLimit = 7;
                break;
            }
    
    
            if(clicks > clicksLimit){
                slider.style.transform = `translateX(-${getItemSize() * clicks-clicksLimit}px)`;
    
                clicks--;
            }
        }, 1000);
    
    });
    
    
    //  Buttons event listerners
    nextBtn.addEventListener('click', () => {
    
        if(clicks < clicksLimit){
            clicks++;
    
        }
    
        let transformVal = getItemSize();
    
        slider.style.transform = `translateX(-${getItemSize() * clicks}px)`;
    })
    
    
    prevBtn.addEventListener('click', () => {
    
        if(clicks != 0){
            clicks--;
    
        }
    
        let transformVal = getItemSize();
    
        slider.style.transform = `translateX(-${getItemSize() * clicks}px)`;    
    })
}



for(let j=0; j<carouselSliderContainer.length; j++){
    bind(carouselSliderContainer[j]);
}

































