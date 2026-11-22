// ==========================================================
// Tests :: Lead Panel Rendering
// ==========================================================
//
// Checks editor values and updates without Vue's runtime template compiler.
//
// ==========================================================

import { test } from "node:test"
import assert from "node:assert/strict"
import { readFileSync } from "node:fs"
import vm from "node:vm"

const h = (tag, data = {}, children = []) => ({
  tag,
  data: { ...data, attrs: data, props: data, on: { input: data.onInput, click: data.onClick } },
  children,
})
const context = { h, resolveComponent: (name) => name }
vm.runInNewContext(
  readFileSync(new URL("../src/blocks/lead.js", import.meta.url), "utf8")
    .replace(/^import .*$/m, "")
    .replace("export default", "component ="),
  context
)
const lead = context.component

test("lead editor renders text and CTA controls and preserves updates", () => {
  const updates = []
  let opened = false
  const editor = {
    disabled: false,
    $t: (key) => key,
    content: { text: "Lead", ctaLabel: "Go" },
    textField: { placeholder: "Text", marks: ["bold"], toolbar: { inline: false } },
    ctaLabelField: { placeholder: "Label" },
    ctaPage: { text: "About" },
    update: (value) => updates.push(value),
    pickCta: () => { opened = true },
    removeCta(event) { event.stopPropagation(); this.update({ cta: [] }) },
  }
  const tree = lead.render.call(editor, h)
  assert.equal(tree.data.class[1]["zeimoto-blocks-lead-fixed"], true)
  const [text, cta] = tree.children
  assert.equal(text.data.props.value, "Lead")
  assert.equal(text.data.props.toolbar, editor.textField.toolbar)
  text.data.on.input("New")
  assert.equal(updates.at(-1).text, "New")
  const [page, label] = cta.children
  assert.equal(label.data.props.value, "Go")
  label.data.on.input("Read")
  assert.equal(updates.at(-1).ctaLabel, "Read")
  assert.equal(page.children[0].tag, "k-items")
  assert.equal(page.children[0].data.props.items[0].text, "About")
  page.data.on.click()
  assert.equal(opened, true)
  const stopped = []
  page.children[0].data.props.items[0].buttons[0].click({ stopPropagation: () => stopped.push(true) })
  assert.equal(stopped.length, 1)
  assert.deepEqual(updates.at(-1).cta, [])
})

test("lead retains the floating toolbar and prompts for a page when empty", () => {
  const editor = { $t: (key) => key, content: {}, textField: {}, ctaLabelField: {}, ctaPage: null, update() {}, pickCta() {} }
  const tree = lead.render.call(editor, h)
  assert.equal(tree.children[0].data.props.toolbar.inline, true)
  assert.equal(tree.data.class[1]["zeimoto-blocks-lead-fixed"], false)
  assert.equal(tree.children[1].children[0].children[0].tag, "k-empty")
})
