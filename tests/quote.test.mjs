// ==========================================================
// Tests :: Quote Panel Rendering
// ==========================================================
//
// Checks editor values and updates without Vue's runtime template compiler.
//
// ==========================================================

import { test } from "node:test"
import assert from "node:assert/strict"
import { readFileSync } from "node:fs"
import vm from "node:vm"

const context = {}
vm.runInNewContext(readFileSync(new URL("../src/blocks/quote.js", import.meta.url), "utf8").replace("export default", "component ="), context)
const quote = context.component
const h = (tag, data, children = []) => ({ tag, data, children })

test("quote editor renders all fields and preserves input updates without compiling templates", () => {
  const updates = []
  const editor = {
    disabled: true,
    content: { text: "Quote", citation: "Author", role: "Designer", source: "https://example.test" },
    textField: { placeholder: "Text", marks: ["bold"], nodes: ["paragraph"], toolbar: { inline: false } },
    citationField: { placeholder: "Author" }, roleField: { placeholder: "Role" }, sourceField: { placeholder: "URL" },
    update: (value) => updates.push(value),
  }
  const tree = quote.render.call(editor, h)
  assert.equal(tree.data.class[1]["zeimoto-blocks-quote-fixed"], true)
  const inputs = [tree.children[0], ...tree.children[1].children]
  assert.equal(inputs.length, 4)
  for (const input of inputs) {
    const name = input.data.ref
    assert.equal(input.data.props.value, editor.content[name])
    assert.equal(input.data.props.disabled, true)
    input.data.on.input("Updated " + name)
    assert.equal(updates.at(-1)[name], "Updated " + name)
  }
  assert.equal(inputs[3].tag, "k-url-input")
  assert.equal(inputs[0].data.props.inline, false)
  assert.equal(inputs[0].data.props.toolbar, editor.textField.toolbar)
})


test("quote retains the floating toolbar when configuration is omitted", () => {
  const editor = { content: {}, textField: {}, citationField: {}, roleField: {}, sourceField: {} }
  const tree = quote.render.call(editor, h)
  assert.equal(tree.children[0].data.props.toolbar.inline, true)
  assert.equal(tree.data.class[1]["zeimoto-blocks-quote-fixed"], false)
})
