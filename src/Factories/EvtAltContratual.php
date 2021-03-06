<?php

namespace NFePHP\eSocial\Factories;

/**
 * Class eSocial EvtAltContratual Event S-2206 constructor
 *
 * @category  NFePHP
 * @package   NFePHPSocial
 * @copyright NFePHP Copyright (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-esocial for the canonical source repository
 */

use NFePHP\Common\Certificate;
use NFePHP\eSocial\Common\Factory;
use NFePHP\eSocial\Common\FactoryInterface;
use stdClass;

class EvtAltContratual extends Factory implements FactoryInterface
{
    /**
     * @var int
     */
    public $sequencial;
    /**
     * @var string
     */
    protected $evtName = 'evtAltContratual';
    /**
     * @var string
     */
    protected $evtAlias = 'S-2206';
    /**
     * Parameters patterns
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Constructor
     *
     * @param string $config
     * @param stdClass $std
     * @param Certificate $certificate
     */
    public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate
    )
    {
        parent::__construct($config, $std, $certificate);
    }

    /**
     * Node constructor
     */
    protected function toNode()
    {
        $ideEmpregador = $this->node->getElementsByTagName('ideEmpregador')->item(0);
        $ideEvento = $this->dom->createElement("ideEvento");
        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "nrRecibo",
            !empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            false
        );
        $this->dom->addChild(
            $ideEvento,
            "tpAmb",
            $this->tpAmb,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "procEmi",
            $this->procEmi,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "verProc",
            $this->verProc,
            true
        );
        $this->node->insertBefore($ideEvento, $ideEmpregador);

        $ideVinculo = $this->dom->createElement("ideVinculo");

        $this->dom->addChild(
            $ideVinculo,
            "cpfTrab",
            $this->std->idevinculo->cpftrab,
            true
        );
        $this->dom->addChild(
            $ideVinculo,
            "nisTrab",
            $this->std->idevinculo->nistrab,
            true
        );
        $this->dom->addChild(
            $ideVinculo,
            "matricula",
            $this->std->idevinculo->matricula,
            true
        );
        $this->node->appendChild($ideVinculo);

        $altContratual = $this->dom->createElement("altContratual");

        $this->dom->addChild(
            $altContratual,
            "dtAlteracao",
            $this->std->altcontratual->dtalteracao,
            true
        );
        $this->dom->addChild(
            $altContratual,
            "dtEf",
            !empty($this->std->altcontratual->dtef) ? $this->std->altcontratual->dtef : null,
            false
        );

        $this->dom->addChild(
            $altContratual,
            "dscAlt",
            !empty($this->std->altcontratual->dscalt) ? $this->std->altcontratual->dscalt : null,
            false
        );

        $vinculo = $this->dom->createElement("vinculo");
        $this->dom->addChild(
            $vinculo,
            "tpRegPrev",
            $this->std->altcontratual->vinculo->tpregprev,
            true
        );
        $altContratual->appendChild($vinculo);
        $infoRegimeTrab = $this->dom->createElement("infoRegimeTrab");
        if (!empty($this->std->altcontratual->inforegimetrab->infoceletista)) {
            $ct = $this->std->altcontratual->inforegimetrab->infoceletista;
            $infoCeletista = $this->dom->createElement("infoCeletista");
            $this->dom->addChild(
                $infoCeletista,
                "tpRegJor",
                $ct->tpregjor,
                true
            );
            $this->dom->addChild(
                $infoCeletista,
                "natAtividade",
                $ct->natatividade,
                true
            );
            $this->dom->addChild(
                $infoCeletista,
                "dtBase",
                !empty($ct->dtbase) ? $ct->dtbase : null,
                false
            );
            $this->dom->addChild(
                $infoCeletista,
                "cnpjSindCategProf",
                $ct->cnpjsindcategprof,
                true
            );

            if (!empty($ct->trabtemp)) {
                $trabTemp = $this->dom->createElement("trabTemp");
                $this->dom->addChild(
                    $trabTemp,
                    "justProrr",
                    $ct->trabtemp->justprorr,
                    true
                );
                $infoCeletista->appendChild($trabTemp);
            }

            if (!empty($ct->aprend)) {
                $aprend = $this->dom->createElement("aprend");
                $this->dom->addChild(
                    $aprend,
                    "tpInsc",
                    $ct->aprend->tpinsc,
                    true
                );
                $this->dom->addChild(
                    $aprend,
                    "nrInsc",
                    $ct->aprend->nrinsc,
                    true
                );
                $infoCeletista->appendChild($aprend);
            }

            $infoRegimeTrab->appendChild($infoCeletista);
        } elseif (!empty($this->std->altcontratual->inforegimetrab->infoestatutario)) {
            $ct = $this->std->altcontratual->inforegimetrab->infoestatutario;
            $infoEstatutario = $this->dom->createElement("infoEstatutario");
            $this->dom->addChild(
                $infoEstatutario,
                "tpPlanRP",
                $ct->tpplanrp,
                true
            );
            $infoRegimeTrab->appendChild($infoEstatutario);
        }
        $altContratual->appendChild($infoRegimeTrab);

        $infoContrato = $this->dom->createElement("infoContrato");
        $ct = $this->std->altcontratual->infocontrato;
        $this->dom->addChild(
            $infoContrato,
            "codCargo",
            !empty($ct->codcargo) ? $ct->codcargo : null,
            false
        );
        $this->dom->addChild(
            $infoContrato,
            "codFuncao",
            !empty($ct->codfuncao) ? $ct->codfuncao : null,
            false
        );
        $this->dom->addChild(
            $infoContrato,
            "codCateg",
            $ct->codcateg,
            true
        );
        $this->dom->addChild(
            $infoContrato,
            "codCarreira",
            !empty($ct->codcarreira) ? $ct->codcarreira : null,
            false
        );
        $this->dom->addChild(
            $infoContrato,
            "dtIngrCarr",
            !empty($ct->dtingrcarr) ? $ct->dtingrcarr : null,
            false
        );

        $remuneracao = $this->dom->createElement("remuneracao");
        $this->dom->addChild(
            $remuneracao,
            "vrSalFx",
            $ct->remuneracao->vrsalfx,
            true
        );
        $this->dom->addChild(
            $remuneracao,
            "undSalFixo",
            $ct->remuneracao->undsalfixo,
            true
        );
        $this->dom->addChild(
            $remuneracao,
            "dscSalVar",
            !empty($ct->remuneracao->dscsalvar) ? $ct->remuneracao->dscsalvar : null,
            false
        );
        $infoContrato->appendChild($remuneracao);
        $duracao = $this->dom->createElement("duracao");
        $this->dom->addChild(
            $duracao,
            "tpContr",
            $ct->duracao->tpcontr,
            true
        );
        $this->dom->addChild(
            $duracao,
            "dtTerm",
            !empty($ct->duracao->dtterm) ? $ct->duracao->dtterm : null,
            false
        );

        $this->dom->addChild(
            $duracao,
            'objDet',
            $ct->duracao->objdet ?? null,
            false
        );

        $infoContrato->appendChild($duracao);

        $localTrabalho = $this->dom->createElement("localTrabalho");
        if (!empty($this->std->altcontratual->infocontrato->localtrabalho->localtrabgeral)) {
            $tg = $this->std->altcontratual->infocontrato->localtrabalho->localtrabgeral;
            $localTrabGeral = $this->dom->createElement("localTrabGeral");
            $this->dom->addChild(
                $localTrabGeral,
                "tpInsc",
                $tg->tpinsc,
                true
            );
            $this->dom->addChild(
                $localTrabGeral,
                "nrInsc",
                $tg->nrinsc,
                true
            );
            $this->dom->addChild(
                $localTrabGeral,
                "descComp",
                !empty($tg->desccomp) ? $tg->desccomp : null,
                false
            );
            $localTrabalho->appendChild($localTrabGeral);
        } elseif (!empty($this->std->altcontratual->infocontrato->localtrabalho->localtrabdom)) {
            $tg = $this->std->altcontratual->infocontrato->localtrabalho->localtrabdom;
            $localTrabDom = $this->dom->createElement("localTrabDom");
            $this->dom->addChild(
                $localTrabDom,
                "tpLograd",
                $tg->tplograd,
                true
            );
            $this->dom->addChild(
                $localTrabDom,
                "dscLograd",
                $tg->dsclograd,
                true
            );
            $this->dom->addChild(
                $localTrabDom,
                "nrLograd",
                $tg->nrlograd,
                true
            );
            $this->dom->addChild(
                $localTrabDom,
                "complemento",
                !empty($tg->complemento) ? $tg->complemento : null,
                false
            );
            $this->dom->addChild(
                $localTrabDom,
                "bairro",
                !empty($tg->bairro) ? $tg->bairro : null,
                false
            );
            $this->dom->addChild(
                $localTrabDom,
                "cep",
                $tg->cep,
                true
            );
            $this->dom->addChild(
                $localTrabDom,
                "codMunic",
                $tg->codmunic,
                true
            );
            $this->dom->addChild(
                $localTrabDom,
                "uf",
                $tg->uf,
                true
            );
            $localTrabalho->appendChild($localTrabDom);
        }
        $infoContrato->appendChild($localTrabalho);

        if (!empty($this->std->altcontratual->infocontrato->horcontratual)) {
            $hc = $this->std->altcontratual->infocontrato->horcontratual;
            $horContratual = $this->dom->createElement("horContratual");
            $this->dom->addChild(
                $horContratual,
                "qtdHrsSem",
                !empty($hc->qtdhrssem) ? $hc->qtdhrssem : null,
                false
            );
            $this->dom->addChild(
                $horContratual,
                "tpJornada",
                $hc->tpjornada,
                true
            );
            $this->dom->addChild(
                $horContratual,
                "dscTpJorn",
                !empty($hc->dsctpjorn) ? $hc->dsctpjorn : null,
                false
            );
            $this->dom->addChild(
                $horContratual,
                "tmpParc",
                $hc->tmpparc,
                true
            );
            if (!empty($hc->horario)) {
                foreach ($hc->horario as $hor) {
                    $horario = $this->dom->createElement("horario");
                    $this->dom->addChild(
                        $horario,
                        "dia",
                        $hor->dia,
                        true
                    );
                    $this->dom->addChild(
                        $horario,
                        "codHorContrat",
                        $hor->codhorcontrat,
                        true
                    );
                    $horContratual->appendChild($horario);
                }
            }
            $infoContrato->appendChild($horContratual);
        }

        if (!empty($this->std->altcontratual->infocontrato->filiacaosindical)) {
            foreach ($this->std->altcontratual->infocontrato->filiacaosindical as $fs) {
                $filiacaoSindical = $this->dom->createElement("filiacaoSindical");
                $this->dom->addChild(
                    $filiacaoSindical,
                    "cnpjSindTrab",
                    $fs->cnpjsindtrab,
                    true
                );
                $infoContrato->appendChild($filiacaoSindical);
            }
        }

        if (!empty($this->std->altcontratual->infocontrato->alvarajudicial)) {
            $alvaraJudicial = $this->dom->createElement("alvaraJudicial");
            $this->dom->addChild(
                $alvaraJudicial,
                "nrProcJud",
                $this->std->altcontratual->infocontrato->alvarajudicial->nrprocjud,
                true
            );
            $infoContrato->appendChild($alvaraJudicial);
        }

        if (!empty($this->std->altcontratual->infocontrato->observacoes)) {
            foreach ($this->std->altcontratual->infocontrato->observacoes as $obs) {
                $observacoes = $this->dom->createElement("observacoes");
                $this->dom->addChild(
                    $observacoes,
                    "observacao",
                    $obs->observacao,
                    true
                );
                $infoContrato->appendChild($observacoes);
            }
        }

        if (!empty($this->std->altcontratual->infocontrato->servpubl)) {
            $servPubl = $this->dom->createElement("servPubl");
            $this->dom->addChild(
                $servPubl,
                "mtvAlter",
                $this->std->altcontratual->infocontrato->servpubl->mtvalter,
                true
            );
            $infoContrato->appendChild($servPubl);
        }

        $altContratual->appendChild($infoContrato);
        $this->node->appendChild($altContratual);
        //finalização do xml
        $this->eSocial->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->eSocial);
        $this->sign();
    }
}
