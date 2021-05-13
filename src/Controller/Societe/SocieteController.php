<?php
// src/Controller/SocieteController.php
namespace App\Controller\Societe;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\SocieteList;
use App\Repository\SocieteListRepository;
use App\Entity\SocieteListTrace;
use App\Entity\FormeJuridique;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SocieteController extends AbstractController
{
    /**
     * @Route("/", name="societe_index")
     */
    public function list(): Response
    {
        $listSociete = $this->getDoctrine()
            ->getRepository(SocieteList::class)
            ->findBy([], ['id' => 'DESC']);

        return $this->render('societe/societeList.html.twig', [
            'listSociete' => $listSociete,
        ]);
    }

    /**
     * @Route("/societe/add", name="societe_add")
     */
    public function add(): Response
    {
        $listFormeJuridique = $this->getDoctrine()
            ->getRepository(FormeJuridique::class)
            ->findAll()
        ;

        return $this->render('societe/societeAdd.html.twig', [
            'listFormeJuridique' => $listFormeJuridique,
        ]);
    }

    /**
     * @Route("/societe/history/{id}", name="societe_history")
     */
    public function history(int $id): Response
    {
        $results = $this->getDoctrine()
            ->getRepository(SocieteListTrace::class)
            ->getSocieteHistoryIdDate($id);

        return $this->render('societe/societeListHistory.html.twig', [
            'listeSelectIdDate' => $results,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/societe/edit/{id}", name="societe_edit")
     */
    public function edit(int $id, SocieteListRepository $societeListRepository): Response
    {
        $societe = $societeListRepository
            ->find($id);
        $listFormeJuridique = $this->getDoctrine()
            ->getRepository(FormeJuridique::class)
            ->findAll()
        ;

        return $this->render('societe/societeEdit.html.twig', [
            'societe' => $societe,
            'listFormeJuridique' => $listFormeJuridique
        ]);
    }

    public function getSocietePosted (SocieteList &$societe, $request, $formeJuridique) : void {
        $societe->setNom($request->request->get('nom'));
        $societe->setCapital($request->request->get('capital'));
        $societe->setFormeJuridique($formeJuridique);
        $societe->setDateImmatriculation( new \DateTime($request->request->get('date_immatriculation')));
        $societe->setNumeroSiren($request->request->get('numero_siren'));
        $societe->setNumero1($request->request->get('numero1'));
        $societe->setTypeVoie1($request->request->get('type_voie1'));
        $societe->setNomVoie1($request->request->get('nom_voie1'));
        $societe->setVille1($request->request->get('ville1'));
        $societe->setCp1($request->request->get('cp1'));
        $societe->setNumero2($request->request->get('numero2'));
        $societe->setTypeVoie2($request->request->get('type_voie2'));
        $societe->setNomVoie2($request->request->get('nom_voie2'));
        $societe->setVille2($request->request->get('ville2'));
        $societe->setCp2($request->request->get('cp2'));
    }

    /**
     * @Route("/societe/societe_submit_edit/{id}", name="societe_submit_edit")
     */
    public function submitEdit(int $id, Request $request, societeListRepository $societeListRepository,
                               ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $societe = $societeListRepository
            ->find($id);

        $formeJuridique = $this->getDoctrine()
            ->getRepository(FormeJuridique::class)
            ->find($request->request->get('forme_juridique'));

        $this->getSocietePosted($societe, $request, $formeJuridique);

        $errors = $validator->validate($societe);
        if (count($errors) > 0) {
            return $this->render('validation.html.twig', [
                'errors' => $errors,
            ]);
        }

        $entityManager->persist($societe);
        $entityManager->flush();
        $this->setTrace($societe, $formeJuridique, 'update');
        $this->addFlash('success', 'La société à bien été mis à jour.');

        return $this->redirectToRoute('societe_index');
    }

    /**
     * @Route("/societe/submit-create", name="societe_submit_create")
     */

    public function submitCreate(Request $request, ValidatorInterface $validator): Response
    {
        //dd($request);
        $entityManager = $this->getDoctrine()->getManager();

        $formeJuridique = $this->getDoctrine()
            ->getRepository(FormeJuridique::class)
            ->find($request->request->get('forme_juridique'));

        $societe = new SocieteList();
        $this->getSocietePosted($societe, $request, $formeJuridique);

        $errors = $validator->validate($societe);
        if (count($errors) > 0) {
            return $this->render('validation.html.twig', [
                'errors' => $errors,
            ]);
        }

        $entityManager->persist($societe);
        $entityManager->flush();
        $this->setTrace($societe, $formeJuridique, 'create');
        $this->addFlash('success', 'La société à bien été créé.');

        return $this->redirectToRoute('societe_index');
    }

    /**
     * @Route("/societe/delete/{id}", name="societe_delete")
     */

    public function deleteSociete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $societe = $entityManager->getRepository(SocieteList::class)->find($id);
        $formeJuridique = $societe->getFormeJuridique();
        $entityManager->remove($societe);
        $this->setTrace($societe, $formeJuridique, 'delete');
        $entityManager->flush();
        $this->addFlash('success', 'La société à bien été supprimée.');
        return $this->redirectToRoute('societe_index');
    }

    //Cloner l'entité de la socité dans la table d'historique
    public function setTrace(SocieteList $societe, FormeJuridique $formeJuridique, $action = 'update') : int {
        $entityManager = $this->getDoctrine()->getManager();

        $societeTrace = new SocieteListTrace();
        $societeTrace->setSocieteId($societe->getId());
        $societeTrace->setNom($societe->getNom());
        $societeTrace->setCapital($societe->getCapital());
        $societeTrace->setFormeJuridique($formeJuridique);
        $societeTrace->setDateImmatriculation( $societe->getDateImmatriculation());
        $societeTrace->setNumeroSiren($societe->getNumeroSiren());
        $societeTrace->setNumero1($societe->getNumero1());
        $societeTrace->setTypeVoie1($societe->getTypeVoie1());
        $societeTrace->setNomVoie1($societe->getNomVoie1());
        $societeTrace->setVille1($societe->getVille1());
        $societeTrace->setCp1($societe->getCp1());
        $societeTrace->setNumero2($societe->getNumero2());
        $societeTrace->setTypeVoie2($societe->getTypeVoie2());
        $societeTrace->setNomVoie2($societe->getNomVoie2());
        $societeTrace->setVille2($societe->getVille2());
        $societeTrace->setCp2($societe->getCp2());
        $societeTrace->setAction($action);

        $entityManager->persist($societeTrace);
        $entityManager->flush();
        return $societeTrace->getId();
    }
}