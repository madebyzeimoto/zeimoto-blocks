// ==========================================================
// Tests :: List Panel Rendering
// ==========================================================
//
// Checks configuration forwarding and the native preview structure.
//
// ==========================================================

import { test } from "node:test"
import assert from "node:assert/strict"
import { readFileSync } from "node:fs"
import vm from "node:vm"

const h = (tag, data = {}) => ({
  tag,
  data: { ...data, attrs: data, props: data, on: { input: data.onInput, click: data.onClick } },
})
const context = { h, resolveComponent: (name) => name }
vm.runInNewContext(
  readFileSync(new URL("../src/blocks/list.js", import.meta.url), "utf8")
    .replace(/^import .*$/m, "")
    .replace("export default", "component ="),
  context
)
const list = context.component

test("list forwards fixed toolbar settings without replacing native input handling", () => {
  const updates = []
  const editor = {
    disabled: true,
    keys: { "Mod-Enter": () => {} },
    content: { text: "<ul><li>First</li></ul>" },
    textField: { marks: ["bold", "italic", "strike", "|", "link", "|", "clear"], nodes: ["bulletList", "orderedList"], toolbar: { inline: false } },
    update: (value) => updates.push(value),
  }
  const tree = list.render.call(editor, h)
  assert.equal(list.extends, "k-block-type-list")
  assert.equal(tree.tag, "k-input")
  assert.equal(tree.data.ref, "input")
  assert.equal(tree.data.attrs.type, "list")
  for (const key of ["marks", "nodes", "toolbar"]) assert.equal(tree.data.attrs[key], editor.textField[key])
  assert.equal(tree.data.attrs.keys, editor.keys)
  assert.equal(tree.data.attrs.disabled, true)
  assert.equal(tree.data.attrs.value, editor.content.text)
  assert.equal(tree.data.class[1]["zeimoto-blocks-list-fixed"], true)
  tree.data.on.input("<ol><li>Updated</li></ol>")
  assert.equal(updates[0].text, "<ol><li>Updated</li></ol>")
})

test("list retains floating toolbar and both list types when settings are omitted", () => {
  const tree = list.render.call({ textField: {}, content: { text: "" } }, h)
  assert.equal(tree.data.attrs.toolbar.inline, true)
  assert.equal(Array.from(tree.data.attrs.nodes).join(","), "bulletList,orderedList")
  assert.equal(tree.data.class[1]["zeimoto-blocks-list-fixed"], false)
})


test("list passes editor settings to Kirby's input wrapper", () => {
  const editor = {
    textField: { marks: ["bold"], nodes: ["bulletList", "orderedList"], toolbar: { inline: false } },
    content: { text: "<ul><li>Item</li></ul>" },
    keys: { "Mod-Enter": () => {} },
  }
  const input = list.render.call(editor, h)
  for (const key of ["marks", "nodes", "toolbar"]) assert.equal(input.data.props[key], editor.textField[key])
  assert.equal(input.data.props.keys, editor.keys)
  assert.equal(input.data.props.type, "list")
})
