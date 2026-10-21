// ==========================================================
// Tests :: Heading Panel Rendering
// ==========================================================
//
// Checks fixed-toolbar layout state and native heading controls.
//
// ==========================================================

import { test } from "node:test"
import assert from "node:assert/strict"
import { readFileSync } from "node:fs"
import vm from "node:vm"

const context = {}
vm.runInNewContext(readFileSync(new URL("../src/blocks/heading.js", import.meta.url), "utf8").replace("export default", "component ="), context)
const heading = context.component
const h = (tag, data, children = []) => ({ tag, data, children })

for (const inline of [false, true, undefined]) {
  test(`heading layout follows toolbar.inline=${inline}`, () => {
    const updates = []
    const editor = {
      $attrs: {}, disabled: false, keys: { Enter: () => {} },
      content: { text: "Heading", level: "h2" },
      textField: { toolbar: inline === undefined ? undefined : { inline }, marks: ["bold"] },
      levels: [{ value: "h2" }, { value: "h3" }],
      update: (value) => updates.push(value),
    }
    const tree = heading.render.call(editor, h)
    assert.equal(heading.extends, "k-block-type-heading")
    assert.equal(tree.data.class[2]["zeimoto-blocks-heading-fixed"], inline === false)
    assert.equal(tree.data.attrs["data-level"], "h2")
    const [input, level] = tree.children
    assert.equal(input.data.ref, "input")
    assert.equal(input.data.attrs.toolbar, editor.textField.toolbar)
    assert.equal(input.data.attrs.keys, editor.keys)
    assert.equal(input.data.attrs.inline, true)
    assert.equal(level.data.ref, "level")
    assert.equal(level.data.attrs.options, editor.levels)
    input.data.on.input("Updated")
    level.data.on.input("h3")
    assert.equal(updates[0].text, "Updated")
    assert.equal(updates[1].level, "h3")
  })
}
