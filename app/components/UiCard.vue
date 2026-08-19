<script setup>
// Small fabricated interface fragments, the way Deel drops a payroll widget or
// a status list into a tile. For a fiduciary these are far more telling than a
// stock photo: they show the artefact the client actually receives.
defineProps({ kind: { type: String, default: 'decompte' } })
</script>

<template>
  <!-- a VAT return being filed -->
  <div v-if="kind === 'decompte'" class="ui">
    <div class="uihd">
      <span class="uit">Décompte TVA</span>
      <span class="uim">2e trimestre</span>
    </div>
    <dl class="uirows">
      <div><dt>Chiffre d'affaires</dt><dd>184 200.—</dd></div>
      <div><dt>TVA due, 8,1 %</dt><dd>14 920.20</dd></div>
      <div><dt>Impôt préalable</dt><dd>−4 380.55</dd></div>
    </dl>
    <div class="uitot"><span>À verser</span><strong>10 539.65</strong></div>
  </div>

  <!-- a payslip breakdown -->
  <div v-else-if="kind === 'salaire'" class="ui">
    <div class="uihd">
      <span class="uit">Fiche de salaire</span>
      <span class="uim">Mars</span>
    </div>
    <dl class="uirows">
      <div><dt>Salaire brut</dt><dd>7 400.—</dd></div>
      <div><dt>AVS, AI, APG</dt><dd>−392.20</dd></div>
      <div><dt>LPP</dt><dd>−318.50</dd></div>
      <div><dt>Assurance chômage</dt><dd>−81.40</dd></div>
    </dl>
    <div class="uitot"><span>Net à payer</span><strong>6 607.90</strong></div>
  </div>

  <!-- the year's obligations, ticked off -->
  <div v-else class="ui">
    <div class="uihd">
      <span class="uit">Vos échéances</span>
      <span class="uim">Suivi</span>
    </div>
    <ul class="uilist">
      <li class="done">
        <svg viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2.5 7.5 5.5 10.5 11.5 4"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
        <span>Certificats de salaire</span><em>31 jan.</em>
      </li>
      <li class="done">
        <svg viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2.5 7.5 5.5 10.5 11.5 4"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
        <span>Déclaration d'impôts</span><em>31 mars</em>
      </li>
      <li>
        <span class="dot" aria-hidden="true" />
        <span>Décompte TVA, T2</span><em>31 août</em>
      </li>
      <li>
        <span class="dot" aria-hidden="true" />
        <span>Bouclement annuel</span><em>déc.</em>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.ui { background: var(--white); border-radius: 12px; padding: 16px 18px;
  box-shadow: 0 16px 34px -22px rgba(0, 25, 52, .38), 0 1px 3px -1px rgba(0, 25, 52, .1);
  font-variant-numeric: tabular-nums }
.uihd { display: flex; align-items: baseline; justify-content: space-between; gap: 12px;
  padding-bottom: 12px; border-bottom: 1px solid var(--hair) }
.uit { font-size: .82rem; font-weight: 680; letter-spacing: -.015em }
.uim { font-size: .72rem; color: var(--faint) }

.uirows { margin: 0; padding: 0 }
.uirows > div { display: flex; align-items: baseline; justify-content: space-between; gap: 14px;
  padding: 9px 0 }
.uirows dt { margin: 0; font-size: .78rem; color: var(--muted) }
.uirows dd { margin: 0; font-size: .82rem; font-weight: 620 }
.uitot { display: flex; align-items: baseline; justify-content: space-between; gap: 14px;
  margin-top: 6px; padding-top: 11px; border-top: 1px solid var(--ink) }
.uitot span { font-size: .78rem; font-weight: 620 }
.uitot strong { font-size: 1.02rem; font-weight: 800; letter-spacing: -.025em; color: var(--red) }

.uilist { list-style: none; margin: 0; padding: 4px 0 0 }
.uilist li { display: grid; grid-template-columns: 16px 1fr auto; align-items: center; gap: 10px;
  padding: 9px 0; font-size: .79rem }
.uilist li + li { border-top: 1px solid var(--hair) }
.uilist svg { width: 14px; height: 14px; color: var(--red) }
.uilist .dot { width: 9px; height: 9px; border-radius: 50%; border: 1.5px solid var(--line);
  margin-left: 2px }
.uilist em { font-style: normal; font-size: .73rem; color: var(--faint) }
.uilist .done span:not(.dot) { color: var(--muted) }
</style>
