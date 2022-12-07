function printError(response) {
   console.error(response);
   if (parseInt(response.status) < 500) {
      let responseText = JSON.parse(response.responseText);
      swal('Error', responseText, 'error');
   } else {
      swal(String(response.status), response.statusText, 'error');
   }
}

function ucwords(text) {
   let token_list = text.split(' ');
   let result = '';
   for (let i = 0; i < token_list.length; ++i) {
      if (i > 0) {
      result += ' ';
      }
      let token = String(token_list[i]);
      let word = token.charAt(0).toUpperCase() + token.slice(1).toLowerCase();
      result += word;
   }
   return result;
}

function createElement(nombre, classes = null, text = null) {
   let element = document.createElement(nombre);

   if (isNotNull(classes)) {
      if (Array.isArray(classes)) {
         for (let i = 0; i < classes.length; ++i) {
            element.classList.add(classes[i]);
         }
      } else {
         element.classList.add(classes);
      }
   }


   if (isNotNull(text)) {
      let textElement = document.createTextNode(text);
      element.appendChild(textElement);
   }

   return element;
}

function createIMGElement(src, classes = null, alt = '') {
   let img = createElement('img', classes);
   img.setAttribute('src', src);
   img.setAttribute('alt', alt);
   return img;
}

function appendChildren(element) {
   for (let i = 1; i < arguments.length; ++i) {
      element.appendChild(arguments[i]);
   }
}

function addStylesToElement(element, styles) {
   for (const property in styles) {
      element.style[property] = styles[property];
   }
}

function isNull(element) {
   return element === null;
}

function isNotNull(element) {
   return !isNull(element);
}

function getExtension(filename) {
   let last_dot_index = filename.lastIndexOf('.');
   if (last_dot_index === -1) {
      return null;
   } else {
      return filename.substring(last_dot_index + 1).toLowerCase();
   }
}

function nameWithoutExtension(filename) {
   let last_dot_index = filename.lastIndexOf('.');
   if (last_dot_index === -1) {
      return filename;
   } else {
      return filename.substring(0, last_dot_index).toLowerCase();
   }
}

// Receive variant number of arguments i.e asset('path', 'to', 'asset')
function asset() {
   let asset_url = ASSET_URL;
   for (let i = 0; i < arguments.length; ++i) {
      if (i > 0) asset_url += '/';
      asset_url += arguments[i];
   }
   return encodeURI(asset_url);
}
