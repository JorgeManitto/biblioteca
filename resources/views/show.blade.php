<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$book->titulo}}</title>
    {{-- cascade --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.0.385/build/pdf.min.js"></script> --}}

  <script src="http://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
  <style>
    body{
        margin: 0;
        background: #333;
        font-family: 'Nunito';
    }
    #canvas_container {
          width: 100%;
          height: 100%;
          overflow: auto;
    }
    #canvas_container {
        background: #333;
        text-align: center;
        margin-top: 1em;
    }
    .nav-container{
        position: sticky;
        top: 0;
        background-color: rgb(59, 59, 59);
        border-bottom: 1px solid #4F4F4F;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: rgb(79, 79, 79);
    }
    .nav{
        display: flex;
        justify-content:space-between;
        padding: 10px;
    }
    #navigation_controls{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn{
        background-color: transparent;
        border: none;
        cursor: pointer;
    }
    #current_page{
        width: 4em;
        text-align: right;
    }
    .count > span, .count > input {
        color: #fff;
        font-size: 13px;
    }
    .fill{
        fill: #fff;
    }
    #myLinks {
        display: none;
        margin-left: 1rem;
        margin-bottom: 2rem;
    }
    .d-none {
    display: none;
    }
    .d-block{
        display: block;
    }

    @media (min-width: 992px){
        .d-lg-block {
            display: block;
        }
        .d-lg-inline-block{
            display: inline-block;
        }
        .d-lg-none {
            display: none;
        }
    }
    .btn-zoom{
        background: transparent;
        border: 1px solid #686868;
        color: #fff;
        /* padding: 0; */
        margin: 0;
        cursor: pointer;
    }
    .btn-zoom:hover{
        color: #333;
        background: #fff;
    }
  </style>
</head>
<body id="body" oncontextmenu="return false;">
     <div id="my_pdf_viewer">
        <div class="nav-container">
            <div class="nav">
                <div class="d-none d-lg-block">
                    <a href="/" style="text-decoration: none;color:#fff;">Volver</a>
                </div>
                <div class="count">
                    <div id="navigation_controls" style="display: inline-block;">
                        <button id="go_previous" class="btn-zoom">Anterior</button>
                        <button id="go_next" class="btn-zoom">Siguiente</button>
                    </div>
                    <input class="btn" id="current_page" value="1" type="number"/>
                    <span> de </span>
                    <span id="page_count"></span>
                    <span class="d-none d-lg-inline-block"> Paginas.</span>
                </div>
                <div class="d-block d-lg-none">
                    <img src="/menu.png" alt="" style="height: 30px;" onclick="menu()">
                </div>
                <div id="zoom_controls" class="d-none d-lg-block">

                    <button class="btn fill" onclick="toggleFullScreen(document.getElementById('pdf_renderer'))">
                        <svg width="20" height="20" viewBox="0 0 20 20" class=""><path d="M10.5 3h6.04l.09.02.06.02.08.04.05.04.06.06.03.04.04.07.03.08.02.08V9.5a.5.5 0 01-1 .09V4.7L4.7 16h4.8a.5.5 0 01.5.41v.09a.5.5 0 01-.41.5H3.41l-.1-.04-.08-.04-.05-.04-.06-.06-.03-.04-.04-.07-.03-.08v-.03a.5.5 0 01-.02-.1v.07-6.07a.5.5 0 011-.09v4.89L15.3 4h-4.8a.5.5 0 01-.5-.41V3.5c0-.28.22-.5.5-.5z" fill-rule="nonzero"></path></svg>
                    </button>
                    <button class="btn fill" id="zoom_in"><svg width="20" height="20" viewBox="0 0 20 20" class=""><path d="M9.5 16.5a.5.5 0 001 0v-6h6a.5.5 0 000-1h-6v-6a.5.5 0 00-1 0v6h-6a.5.5 0 000 1h6v6z" fill-rule="nonzero"></path></svg></button>
                    <button class="btn fill" id="zoom_out"><svg width="20" height="20" viewBox="0 0 20 20" class=""><path d="M3 10c0-.28.22-.5.5-.5h13a.5.5 0 010 1h-13A.5.5 0 013 10z"></path></svg></button>
                </div>
            </div>
            <div id="myLinks">
                <div style="display: flex;justify-content: space-between;">
                    <a href="/" style="text-decoration: none;color:#fff;">Volver</a>
                    <div>
                        <button class="btn fill" onclick="toggleFullScreen(document.getElementById('pdf_renderer'))">
                            <svg width="20" height="20" viewBox="0 0 20 20" class=""><path d="M10.5 3h6.04l.09.02.06.02.08.04.05.04.06.06.03.04.04.07.03.08.02.08V9.5a.5.5 0 01-1 .09V4.7L4.7 16h4.8a.5.5 0 01.5.41v.09a.5.5 0 01-.41.5H3.41l-.1-.04-.08-.04-.05-.04-.06-.06-.03-.04-.04-.07-.03-.08v-.03a.5.5 0 01-.02-.1v.07-6.07a.5.5 0 011-.09v4.89L15.3 4h-4.8a.5.5 0 01-.5-.41V3.5c0-.28.22-.5.5-.5z" fill-rule="nonzero"></path></svg>
                        </button>
                        <button class="btn fill" id="zoom_in_1">
                            <svg width="20" height="20" viewBox="0 0 20 20" class="">
                            <path d="M9.5 16.5a.5.5 0 001 0v-6h6a.5.5 0 000-1h-6v-6a.5.5 0 00-1 0v6h-6a.5.5 0 000 1h6v6z" fill-rule="nonzero"></path>
                        </svg>
                        </button>
                        <button class="btn fill" id="zoom_out_1">
                            <svg width="20" height="20" viewBox="0 0 20 20" class="">
                             <path d="M3 10c0-.28.22-.5.5-.5h13a.5.5 0 010 1h-13A.5.5 0 013 10z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div id="canvas_container">
            <canvas id="pdf_renderer" ></canvas>
            {{-- <div id="handle"></div> --}}
        </div>
    </div>
    <script>
        var myState = {
            pdf: null,
            currentPage: 1,
            zoom: 1
        }
@php
$url= '';
if($book->url){
                    $url= str_replace('public/', '', $book->url);
                    $url = asset('storage/'.$url);
}
@endphp
        pdfjsLib.getDocument('{{$url}}').then((pdf) => {

            myState.pdf = pdf;
            document.getElementById('page_count').innerHTML=myState.pdf.numPages;
            render();
        });
        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {

                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');

                var viewport = page.getViewport(myState.zoom);
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });
            });


        }


        document.getElementById('go_previous').addEventListener('click', (e) => {
            if(myState.pdf == null || myState.currentPage == 1)
              return;
            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
        document.getElementById('go_next').addEventListener('click', (e) => {
            if(myState.pdf == null || myState.currentPage >= myState.pdf.numPages)
               return;
            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });
        document.getElementById('current_page').addEventListener('keypress', (e) => {
            if(myState.pdf == null) return;

            // Get key code
            var code = (e.keyCode ? e.keyCode : e.which);

            // If key code matches that of the Enter key
            if(code == 13) {
                var desiredPage =
                document.getElementById('current_page').valueAsNumber;

                if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                    myState.currentPage = desiredPage;
                    document.getElementById("current_page").value = desiredPage;
                    render();
                }
            }
        });
        document.getElementById('zoom_in').addEventListener('click', zoom_in);
        document.getElementById('zoom_out').addEventListener('click',zoom_out);


        document.getElementById('zoom_in_1').addEventListener('click',zoom_in);
        document.getElementById('zoom_out_1').addEventListener('click',zoom_out);

        function zoom_in() {
            if(myState.zoom < 2){
                myState.zoom += 0.2;
                render();
            }
        }
        function zoom_out() {
            if(myState.pdf == null) return;
            if(myState.zoom > 0.6)
            {
                myState.zoom -= 0.2;
                render();
            }
        }

        function toggleFullScreen(elem) {
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            myState.zoom = 2;
            render();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}
document.onkeydown = checkKey;

function checkKey(e) {

    e = e || window.event;

    if (e.keyCode == '109') {
        if(myState.pdf == null) return;
            if(myState.zoom > 0.6)
            {
                myState.zoom -= 0.2;
                render();
            }
            console.log(myState.zoom);
    }
    else if (e.keyCode == '107') {
        if(myState.pdf == null) return;
        if(myState.zoom < 2){
            myState.zoom += 0.2;
            render();
        }
            console.log(myState.zoom);
    }
    else if (e.keyCode == '37') {
        if(myState.pdf == null || myState.currentPage == 1)
              return;
            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
    }
    else if (e.keyCode == '39') {
        if(myState.pdf == null || myState.currentPage >= myState.pdf.numPages)
               return;
            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
    }

}
function menu() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}


        // Cascade
        // function test() {
        //     document.getElementById("pdf_renderer").style.display = "none";
        //     renderPDF('/test.pdf', document.getElementById('handle'));
        // }
        // function renderPDF(url, canvasContainer, options) {

        //     options = options || { scale: 1 };

        //     function renderPage(page) {
        //         var viewport = page.getViewport(options.scale);
        //         var wrapper = document.createElement("div");
        //         wrapper.className = "canvas-wrapper";
        //         var canvas = document.createElement('canvas');
        //         var ctx = canvas.getContext('2d');
        //         var renderContext = {
        //         canvasContext: ctx,
        //         viewport: viewport
        //         };

        //         canvas.height = viewport.height;
        //         canvas.width = viewport.width;
        //         wrapper.appendChild(canvas)
        //         canvasContainer.appendChild(wrapper);

        //         page.render(renderContext);
        //     }

        //     function renderPages(pdfDoc) {
        //         for(var num = 1; num <= pdfDoc.numPages; num++)
        //             pdfDoc.getPage(num).then(renderPage);
        //     }

        //     PDFJS.disableWorker = true;
        //     PDFJS.getDocument(url).then(renderPages);

        //     }


    </script>
</body>
</html>
