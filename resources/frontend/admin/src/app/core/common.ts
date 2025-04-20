export const makeDate = (dateString: string): Date | null => {
  if (dateString) {
    // do check to make sure it is valid date
    if (isNaN(Date.parse(dateString))) {
      return null;
    }

    return new Date(dateString);
  }
  return null;
};

// generate a random quick key
export const uuid = (): string => {
  if (window?.crypto) {
    var buf = new Uint32Array(4);
    window.crypto.getRandomValues(buf);
    var idx = -1;
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(
      /[xy]/g,
      function (c) {
        idx++;
        var r = (buf[idx >> 3] >> ((idx % 8) * 4)) & 15;
        var v = c == 'x' ? r : (r & 0x3) | 0x8;
        return v.toString(16);
      }
    );
  } else {
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(
      /[xy]/g,
      function (c) {
        var r = (dt + Math.random() * 16) % 16 | 0;
        dt = Math.floor(dt / 16);
        return (c == 'x' ? r : (r & 0x3) | 0x8).toString(16);
      }
    );
    return uuid;
  }
};


export const hasMore = (total: number, size: number, currentPage: number): boolean => {

  if (total === 0) { return false; }

  const pages = Math.ceil(total / size);
  if (currentPage === pages) {
    // no more pages
    return false;
  } else {
    // yes more
    return true;
  }
};

export const toFormat = (s:string, ...args: any) => {
  const regExp = /\$(\d+)/gi;
  // match $1 $2 ...
  return s.replace(regExp, (match, index) => {
    return args[index] ?? match;
  });

}

/*
function copied from https://github.com/angus-c/just/blob/master/packages/collection-clone/index.js
  Deep clones all properties except functions
  var arr = [1, 2, 3];
  var subObj = {aa: 1};
  var obj = {a: 3, b: 5, c: arr, d: subObj};
  var objClone = clone(obj);
  arr.push(4);
  subObj.bb = 2;
  obj; // {a: 3, b: 5, c: [1, 2, 3, 4], d: {aa: 1}}
  objClone; // {a: 3, b: 5, c: [1, 2, 3], d: {aa: 1, bb: 2}}
*/
const getRegExpFlags = (regExp: any) => {
  if (typeof regExp.source.flags == 'string') {
    return regExp.source.flags;
  } else {
    var flags = [];
    regExp.global && flags.push('g');
    regExp.ignoreCase && flags.push('i');
    regExp.multiline && flags.push('m');
    regExp.sticky && flags.push('y');
    regExp.unicode && flags.push('u');
    return flags.join('');
  }
};
export const clone = (obj: any) => {
  if (typeof obj == 'function') {
    return obj;
  }
  var result = Array.isArray(obj) ? [] : {};
  for (var key in obj) {
    // include prototype properties
    var value = obj[key];
    var type = {}.toString.call(value).slice(8, -1);
    if (type == 'Array' || type == 'Object') {
      result[key] = clone(value);
    } else if (type == 'Date') {
      result[key] = new Date(value.getTime());
    } else if (type == 'RegExp') {
      result[key] = RegExp(value.source, getRegExpFlags(value));
    } else {
      result[key] = value;
    }
  }
  return result;
};
