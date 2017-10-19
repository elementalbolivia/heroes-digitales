'use strict';
const fs = require('fs');
const path = require('path');

const Loader = (function (){
  const ABS_DIR = __dirname;

  const getFiles = (dir, specifDir) => {
    const filesInDir = [];
    const pathToFile = path.join(ABS_DIR, dir);
    const dirs = fs.readdirSync(pathToFile);
    for (let i = 0; i < dirs.length; i++) {
      if(dirs[i] == '.DS_Store')
        continue;
      else{
        const actPath = pathToFile + '/' + dirs[i];
        const files = fs.readdirSync(actPath);
        for (let j = 0; j < files.length; j++) {
          filesInDir.push(path.join(specifDir, dirs[i], files[j]).slice(1) );
        }
      }
    }
    return filesInDir;
  }

  return {
    getFiles: (dir, concatDir) => {
      return getFiles(dir, concatDir);
    }
  }
})();
module.exports = Loader;
