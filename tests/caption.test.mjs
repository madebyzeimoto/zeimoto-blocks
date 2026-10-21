// ==========================================================
// Tests :: Caption Panel Rendering
// ==========================================================
//
// Checks shared media caption formatting and input updates.
//
// ==========================================================

import { test } from "node:test"
import assert from "node:assert/strict"
import { readFileSync } from "node:fs"
import vm from "node:vm"

const context = {}
vm.runInNewContext(readFileSync(new URL("../src/blocks/caption.js", import.meta.url), "utf8").replace("export default", "component ="), context)
const caption = context.component
const h = (tag, data, children = []) => ({ tag, data, children })

test("media captions use a fixed toolbar and preserve native rich text updates", () => {
  const events = []
  const editor = { disabled: true, marks: ["bold", "italic", "link"], value: "<strong>Caption</strong>", $emit: (...args) => events.push(args) }
  const tree = caption.render.call(editor, h)
  assert.equal(caption.extends, "k-block-figure-caption")
  assert.equal(tree.tag, "figcaption")
  assert.ok(tree.data.class.includes("zeimoto-blocks-caption-fixed"))
  const input = tree.children[0]
  assert.equal(input.tag, "k-writer-input")
  assert.equal(input.data.attrs.toolbar.inline, false)
  assert.equal(input.data.attrs.inline, true)
  assert.equal(input.data.attrs.disabled, true)
  assert.equal(input.data.attrs.marks, editor.marks)
  assert.equal(input.data.attrs.value, editor.value)
  input.data.on.input("<em>Updated</em>")
  assert.deepEqual(events, [["input", "<em>Updated</em>"]])
})
