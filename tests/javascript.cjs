const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const handlers = {};
const events = [];
const input = {value: 'PHP,C++', dispatchEvent: e => events.push(e.type)};
const list = {hidden: false};
const attributes = {'aria-controls': 'cloud', 'aria-expanded': 'true'};
const button = {dataset: {expanded: '0'}, getAttribute: key => attributes[key], setAttribute: (key, value) => attributes[key] = value, classList: {toggle() {}}};
const context = {window: {}, Event: class {constructor(type) {this.type=type;}}, document: {
    readyState: 'complete',
    getElementById: id => id === 'tags' ? input : id === 'cloud' ? list : null,
    querySelectorAll: () => [button],
    addEventListener: (type, listener) => (handlers[type] ??= []).push(listener),
}};
vm.createContext(context);
for (const name of ['tag.js','tagcloud.js']) vm.runInContext(fs.readFileSync(path.join(__dirname,'../src/Resources/public/js',name),'utf8'),context);
context.window.Tag.selectedTag('C++','tags');
assert.equal(input.value,'PHP');
context.window.Tag.selectedTag("O'Reilly (100%)",'tags');
assert.equal(input.value,"PHP,O'Reilly (100%)");
context.window.Tag.selectedTag('php','tags');
assert.equal(input.value,"O'Reilly (100%)");
assert.deepEqual(events,['input','change','input','change','input','change']);
assert.equal(list.hidden,true);
assert.equal(attributes['aria-expanded'],'false');
handlers.click[1]({target: {closest: () => button}});
assert.equal(list.hidden,false);
assert.equal(attributes['aria-expanded'],'true');
console.log('Native tag selection and accessible cloud toggles passed.');
