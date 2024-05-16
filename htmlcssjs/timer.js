onmessage = function(event){
    setTimeout(() => {
        postMessage(event.data);
      }, event.data);
}
