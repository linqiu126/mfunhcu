
var http = require("http");
var fs = require('fs');
var url = require('url');
var req = require('/xhzn/mfunhcu/ui/ejs/req');


http.createServer(function(request, response) {
    console.log(request.url);
    var pathname = url.parse(request.url,false).pathname;
    var ext = pathname.match(/(\.[^.]+|)$/)[0];
    var Data="";

    switch(ext){
        case ".css":
            console.log("Client require :"+pathname);
            Data = fs.readFileSync("."+pathname,'utf-8');
            response.writeHead(200, {"Content-Type": "text/css"});
            response.write(Data);
            response.end();
            break;
        case ".js":
            console.log("Client require :"+pathname);
            Data = fs.readFileSync("."+pathname,'utf-8');
            response.writeHead(200, {"Content-Type": "application/javascript"});
            response.write(Data);
            response.end();
            break;
        case ".map":
            console.log("Client require :"+pathname);
            Data = fs.readFileSync("."+pathname,'utf-8');
            response.writeHead(200, {"Content-Type": "application/javascript"});
            response.write(Data);
            response.end();
            break;
        case ".ico":

            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            response.writeHead(200, {"Content-Type": "image/x-ico"});
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var img = fs.readFileSync(file);
                response.contentType = 'image/x-ico';
                response.contentLength = stat.size;
                response.end(img, 'binary');
            });
            break;
        case ".png":
            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            response.writeHead(200, {"Content-Type": "image/png"});

            //fs.createReadStream("."+pathname, 'utf-8').pipe(response);
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var img = fs.readFileSync(file);
                response.contentType = 'image/png';
                response.contentLength = stat.size;
                response.end(img, 'binary');
            });
            break;
        case ".jpg":
            break;
        case ".gif":
            break;
        case ".swf":
            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            //response.writeHead(200, {"Content-Type": "application/x-shockwave-flash"});

            //fs.createReadStream("."+pathname, 'utf-8').pipe(response);
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var swf = fs.readFileSync(file);
                response.contentType = 'application/x-shockwave-flash';
                response.contentLength = stat.size;
                response.end(swf, 'binary');
            });
            break;
        case ".woff":
            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            response.writeHead(200, {"Content-Type": "application/x-font-woff"});
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var img = fs.readFileSync(file);
                response.contentType = 'application/font-woff';
                response.contentLength = stat.size;
                response.end(img, 'binary');
            });
            break;
        case ".woff2":
            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            response.writeHead(200, {"Content-Type": "font/woff2"});
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var img = fs.readFileSync(file);
                response.contentType = 'font/woff2';
                response.contentLength = stat.size;
                response.end(img, 'binary');
            });
            break;
        case ".ttf":
            console.log("Client require :"+pathname);
            //Data = fs.readFileSync("."+pathname,'binary');
            response.writeHead(200, {"Content-Type": "application/x-font-ttf"});
            //response.write(Data);
            //response.end();
            var file = "."+pathname;
            fs.stat(file, function (err, stat) {
                var img = fs.readFileSync(file);
                response.contentType = 'application/x-font-ttf';
                response.contentLength = stat.size;
                response.end(img, 'binary');
            });
            break;
        case ".html":
            console.log("Client require :"+pathname);
            Data = fs.readFileSync('./RFTP.html','utf-8');
            response.writeHead(200, {"Content-Type": "text/html"});
            response.write(Data);
            response.end();
            break;
        case ".php":
            //2 different PHP file:dump.php&request.php
            var filename = pathname.replace(/^.*\/|\..*$/g, "");
            console.log("Client require PHP file :"+filename);
            if(filename == "request"){
                console.log("Client require :"+pathname);
                var arg = url.parse(request.url,true).query;
                console.log(arg);
                var ret = req.database(arg);
                console.log("Server response :"+ret);
                response.writeHead(200, { 'Content-Type': 'text/html;charset=utf-8' });
                response.write(ret);
                response.end();
            }else if(filename == "jump"){
                console.log("Client require :"+pathname);
                var arg = url.parse(request.url,true).query;
                console.log(arg);
                var ret = req.check_usr(arg);
                if(ret != ""){
                    Data = fs.readFileSync('./scope.html','utf-8');
                    response.writeHead(200, {"Content-Type": "text/html"});
                    response.write(Data);
                    response.end();
                }else{
                    Data = fs.readFileSync('./Login.html','utf-8');
                    response.writeHead(200, {"Content-Type": "text/html"});
                    response.write(Data);
                    response.end();
                }
            }
            break;
        case ".request":
            console.log("Client require :"+pathname);
            var arg = url.parse(request.url,true).query;
            console.log(arg);
            var ret = req.database(arg);
            console.log("Server response :"+ret);
            response.writeHead(200, { 'Content-Type': 'text/html;charset=utf-8' });
            response.write(ret);
            response.end();
            break;
        case ".jump":
            console.log("Client require :"+pathname);
            var arg = url.parse(request.url,true).query;
            console.log(arg);
            var ret = req.check_usr(arg);
            if(ret != ""){
                Data = fs.readFileSync('./scope.html','utf-8');
                response.writeHead(200, {"Content-Type": "text/html"});
                response.write(Data);
                response.end();
            }else{
                Data = fs.readFileSync('./Login.html','utf-8');
                response.writeHead(200, {"Content-Type": "text/html"});
                response.write(Data);
                response.end();
            }
            break;
        default:
            console.log("Client require :"+pathname);
                Data = fs.readFileSync('./Login.html','utf-8');
                response.writeHead(200, {"Content-Type": "text/html"});
                response.write(Data);
                response.end();
    }

}).listen(8888);
//req.req_test();
console.log("server start......");

