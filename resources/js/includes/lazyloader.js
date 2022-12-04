import docReady from "./document-ready"
import wsnLazyLoad from "./lazyload";


const observer = wsnLazyLoad()

const lazyLoadDomChanges = () =>{
    document.body.addEventListener('lazy-load', function(){
        wsnLazyLoad('.actually-lazy');
    })  
}

docReady(observer.observe())
docReady(lazyLoadDomChanges)