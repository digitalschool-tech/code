import docReady from "../includes/document-ready";

const anchorMenu = () => {
    const navigation = document.querySelector("#menu")
    console.log(navigation)
    // const menu = document.querySelector("#menu")
    let lastDistance = 0;
    window.addEventListener('scroll', function() {
        let distanceFromTop = document.body.scrollTop || document.documentElement.scrollTop;
        if(lastDistance > distanceFromTop){
            menu.classList.remove("-translate-y-[200px]")
            menu.classList.add("translate-y-0")
            console.log("up")

        }else{
            menu.classList.add("-translate-y-[200px]")
            menu.classList.remove("translate-y-0")

            console.log("down")
        }
        lastDistance = distanceFromTop
    });
}

docReady(anchorMenu)

