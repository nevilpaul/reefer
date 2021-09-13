export const appendScript =(scriptTag)=>{
    var script = document.createElement('script');
    script.src = scriptTag;
    script.async = true;
    document.body.appendChild(script);
}
