// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Quote
// ==========================================================
//
// Extends Kirby's native quote block editor with zeimoto's
// attribution metadata while preserving the core editing flow.
//
// ==========================================================

export default {
  extends: "k-block-type-quote",
  computed: {
    roleField() {
      return this.field("role", {})
    },
    sourceField() {
      return this.field("source", {})
    },
  },
  render(h) {
    return h("div", { class: "k-block-type-quote-editor" }, [
      h("k-writer-input", {
        ref: "text",
        class: "k-block-type-quote-text",
        props: {
          disabled: this.disabled,
          inline: this.textField.inline ?? false,
          marks: this.textField.marks,
          nodes: this.textField.nodes,
          placeholder: this.textField.placeholder,
          value: this.content.text,
        },
        on: { input: (value) => this.update({ text: value }) },
      }),
      h("div", { class: "k-block-type-quote-grid" }, [
        ["citation", "k-text-input", this.citationField],
        ["role", "k-text-input", this.roleField],
        ["source", "k-url-input", this.sourceField],
      ].map(([name, component, field]) => h(component, {
        ref: name,
        class: `k-block-type-quote-${name}`,
        props: { disabled: this.disabled, placeholder: field.placeholder, value: this.content[name] },
        on: { input: (value) => this.update({ [name]: value }) },
      }))),
    ])
  },
}
