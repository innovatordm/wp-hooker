$( document ).ready(function() {
    var graph = new joint.dia.Graph;

    var paper = new joint.dia.Paper({
        el: $('#myholder'),
        width: 800,
        height: 500,
        model: graph,
        gridSize: 1
    });
    var hooksObj = []; /*
    $.each(wpHookers, function(index, value) {
        hooksObj.push(
            new joint.shapes.basic.Rect({
                position: { x: 100, y: 30 },
                size: { width: 100, height: 30 },
                attrs: { rect: { fill: 'blue' }, text: { text: index, fill: 'white' } }
            })
        );  
    }); */

    function generateDrawObject (name, object, posX, posY) {
            var draw = new joint.shapes.basic.TextBlock({
                position: { x: posX, y: posY },
                size: { width: 100, height: 100 },
                attrs: { rect: { fill: 'green' }},
                content: "<p style='color:white;'>" + name + "</p>"

            }); 
            return draw;
    }

    function drawPlacement (platWid, platHei, wid, hei, hashArr) {
        var posX = Math.floor(Math.random()*(wid-platWid)/platWid)*platWid,
            posY = Math.floor(Math.random()*(hei-platHei)/platHei)*platHei;
  
      while (hash[posX + 'x' + posY]){
        posX = Math.floor(Math.random()*wid/platWid)*platWid;
        posY = Math.floor(Math.random()*hei/platHei)*platHei;
      }

      hashArr[posX + 'x' + posY] = 1;

      return {posX, posY}
    }

    var wpHookerKeys = Object.keys(wpHookers),
        hash = {};

    /*
    for (var i = wpHookerKeys.length - 1; i >= 0; i--) { 
        hooksObj.push(generateDrawObject(wpHookers[wpHookerKeys[i]]));
    }; */

    (function theLoop (i) {
      setTimeout(function () {
        var pos = drawPlacement(100, 100, 800, 500, hash);
        console.log(pos);
        hooksObj.push(generateDrawObject( wpHookerKeys[i], wpHookers[wpHookerKeys[i]], pos.posX, pos.posY ));
        graph.addCell(hooksObj[hooksObj.length - 1]);
        if (--i) {          // If i > 0, keep going
          theLoop(i);       // Call the loop again, and pass it the current value of i
        } else {

        }
      }, 100);
    })(10);

    /*
    graph.addCell(hooksObj[1]);
    

    setInterval(function(){
        if(counter < hooksObj.length) {
            graph.addCell(hooksObj[counter]);
            counter++;
        } else {
            return;
        }
    }, 300);

    for (var i = hooksObj.length - 1; i >= 0; i--) {
        graph.addCell(hooksObj[i]);
    };
    
    var rect2 = rect.clone();
    rect2.translate(300); 

    var link = new joint.dia.Link({
        source: { id: rect.id },
        target: { id: rect2.id }
    });

    graph.addCells([rect, rect2, link]);
    */
});