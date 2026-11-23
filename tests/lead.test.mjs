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
  const editor = {
    disabled: false,
    content: { text: "Lead", ctaLabel: "Go" },
    textField: { placeholder: "Text", marks: ["bold"], toolbar: { inline: false } },
    ctaLabelField: { placeholder: "Label" },
    ctaIds: ["page://about"],
    endpoints: { field: "pages/home/fields/blocks" },
    field: () => ({ multiple: false }),
    update: (value) => updates.push(value),
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
  assert.equal(page.tag, "k-zeimoto-lead-pagepicker")
  assert.equal(page.data.props.value, editor.ctaIds)
  assert.equal(page.data.props.multiple, false)
  assert.equal(page.data.props.endpoints.field, "pages/home/fields/blocks/fieldsets/lead/fields/cta")
  page.data.on.input(["page://contact"])
  assert.deepEqual(updates.at(-1).cta, ["page://contact"])
  page.data.on.input([])
  assert.deepEqual(updates.at(-1).cta, [])
})

test("lead retains the floating toolbar and prompts for a page when empty", () => {
  const editor = { content: {}, textField: {}, ctaLabelField: {}, ctaIds: [], field: () => ({}), endpoints: { field: "blocks" } }
  const tree = lead.render.call(editor, h)
  assert.equal(tree.children[0].data.props.toolbar.inline, true)
  assert.equal(tree.data.class[1]["zeimoto-blocks-lead-fixed"], false)
  assert.deepEqual(tree.children[1].children[0].data.props.value, [])
})

test("lead accepts stored references and older item objects", () => {
  const cta = ["page://current", { uuid: "page://legacy", id: "old" }, { id: "older" }]
  assert.deepEqual(lead.computed.ctaIds.call({ content: { cta } }), ["page://current", "page://legacy", "older"])
})
