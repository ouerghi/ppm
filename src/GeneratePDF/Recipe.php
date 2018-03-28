<?php


namespace App\GeneratePDF;


use Spipu\Html2Pdf\Html2Pdf;

class Recipe
{
  private $pdf;

  public function create($orientation = null, $format = null, $lang = null, $unicode = null, $encoding = null, $margin = null)
  {
      $this->pdf = new Html2Pdf(
          $orientation ? $orientation: $this->orientation,
          $format ? $format: $this->format,
          $lang ? $lang: $this->lang,
          $unicode ? $unicode: $this->unicode,
          $encoding ? $encoding: $this->encoding,
          $margin ? $margin: $this->margin
      );
  }

  public function generatePdf($template, $name)
  {
      $this->pdf->pdf->SetDisplayMode('fullpage');
      $this->pdf->writeHTML($template);
      return $this->pdf->Output($name.'.pdf');
  }
}