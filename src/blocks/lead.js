// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Lead
// ==========================================================
//
// Edits lead text inline like the quote block, with the CTA
// label inline and the CTA page chosen in Kirby's page picker.
//
// ==========================================================

import { h, resolveComponent } from "vue"

export default {
  extends: "k-block-type-quote",
  computed: {
    textField() {
      return this.field("text", {})
    },
    ctaLabelField() {
      return this.field("ctaLabel", {})
    },
    ctaIds() {
      return (this.content.cta ?? [])
        .map((page) => (typeof page === "string" ? page : page?.uuid ?? page?.id))
        .filter(Boolean)
    },
  },
  methods: {
    focus() {
      this.$refs.text?.focus()
    },
  },
  render() {
    const writerInput = resolveComponent("k-writer-input")
    const pagepicker = resolveComponent("k-zeimoto-lead-pagepicker")
    const textInput = resolveComponent("k-text-input")

    return h(
      "div",
      {
        class: ["k-block-type-lead-editor", { "zeimoto-blocks-lead-fixed": this.textField.toolbar?.inline === false }],
      },
      [
        h(writerInput, {
          ref: "text",
          class: "k-block-type-lead-text",
          disabled: this.disabled,
          inline: this.textField.inline ?? false,
          marks: this.textField.marks,
          nodes: this.textField.nodes,
          toolbar: this.textField.toolbar ?? { inline: true },
          placeholder: this.textField.placeholder ?? "Text …",
          value: this.content.text,
          onInput: (value) => this.update({ text: value }),
        }),
        h("div", { class: "k-block-type-lead-cta" }, [
          h(pagepicker, {
            ...this.field("cta", {}),
            disabled: this.disabled,
            endpoints: {
              ...this.endpoints,
              field: this.endpoints.field + "/fieldsets/" + (this.fieldset?.type ?? "lead") + "/fields/cta",
            },
            value: this.ctaIds,
            onInput: (value) => this.update({ cta: value }),
          }),
          h(textInput, {
            ref: "ctaLabel",
            class: "k-block-type-lead-cta-label",
            disabled: this.disabled,
            placeholder: this.ctaLabelField.placeholder ?? "CTA label …",
            value: this.content.ctaLabel,
            onInput: (value) => this.update({ ctaLabel: value }),
          }),
        ]),
      ]
    )
  },
}
