// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: List
// ==========================================================
//
// Forwards field configuration while retaining native list editing.
//
// ==========================================================

export default {
  extends: "k-block-type-list",
  computed: {
    textField() {
      return this.field("text", {})
    },
  },
  render(h) {
    return h("k-input", {
      ref: "input",
      class: ["k-block-type-list-input", { "zeimoto-blocks-list-fixed": this.textField.toolbar?.inline === false }],
      // k-input forwards editor-specific settings through $attrs.
      attrs: {
        type: "list",
        disabled: this.disabled,
        keys: this.keys,
        marks: this.textField.marks,
        nodes: this.textField.nodes ?? ["bulletList", "orderedList"],
        toolbar: this.textField.toolbar ?? { inline: true },
        value: this.content.text,
      },
      on: { input: (value) => this.update({ text: value }) },
    })
  },
}
