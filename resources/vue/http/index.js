export default class Http {
    constructor(global){
        this.headers = global.headers
        this.base = global.base || ""
        this.withCredentials = global.withCredentials;
        this.cors = global.cors
    }
    createXHR(method, url){
        var xhr = null;
        xhr = new XMLHttpRequest();
        if(xhr){
            xhr.open(method || "GET", `${this.base + url}`)
            xhr.xml  = () => xhr.responseXML
            xhr.json = () => JSON.parse(xhr.responseText)
            for(let header in this.headers){
                xhr.setRequestHeader(header, this.headers[header].constructor == Function? this.headers[header]() : this.headers[header])
            }
            xhr.withCredentials = this.withCredentials
        }
        return xhr;
    }
    request(requestObject){
        return new Promise((resolve, reject) => {
            var xhr = this.createXHR(requestObject.method, requestObject.url);
            for(let header in requestObject.headers){
                xhr.setRequestHeader(header, requestObject.headers[header].constructor == Function? requestObject.headers[header]() : requestObject.headers[header])
            }
            if(!this.cors){
                xhr.setRequestHeader("cache-control", "no-cache")
            }
            xhr.timeout = requestObject.timeout || 15000;
            xhr.ontimeout = () => {
                xhr.abort()
                return reject("The connection timed out. Please try again.")
            }
            xhr.onerror = (e) => {
                return reject("An Error occured!" + e)
            }
            try{
                xhr.send(requestObject.content)
            } catch(e){
                reject("Request failed! " + e)
            }
            xhr.onload = () => resolve(xhr)
        })
    }
    post(url, params = {}, contentType = ""){
        var content, headers;
        if(contentType == "application/json"){
            content = params
            headers = {"Content-Type": contentType}
        }
        else{
            content = new FormData();
            for(var param in params)
                content.append(param, params[param])
            headers = {}
        }

        return this.request({
            url,
            method: "post",
            content,
            headers
        })
    }
    get(url, params = {}){
        var query = ""
        for(var param in params){
            query += `&${param}=${escape(params[param])}`
        }
        query = query.substring(1)
        return this.request({
            url: `${url}?${query}`
        })
    }
    getJSON(url, params, method = "GET", contentType = ""){
        if(method == "POST"){
            return this.post(url, params, contentType).then(response => response.json())
        }
        return this.get(url, params).then(response => response.json())
    }
}
