window.Echo.channel("chat").listen("MessageSent",o=>{console.log("Новое сообщение:",o),new Audio("/audio/notification.mp3").play().catch(e=>{console.error("Ошибка воспроизведения звука:",e)})});
