/*
 * Auteur : Dylan Schito, Robin Brunazzi, Kilian Perisset
 * Date : 02.10.2018
 * Projet : Cité des métiers
 * Description : Classe définissant les évènements et méthodes relatives à la forme/vue principale.
 */


using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace CdM_Aquarium
{
    public partial class frmPrincipale : Form
    {
        public frmPrincipale()
        {
            this.Icon = Properties.Resources.icon_poisson;
            DoubleBuffered = true;
            //Aquarium aquarium = new Aquarium(this);
            SceneParDefaut scene1 = new SceneParDefaut(this);

        }
    }
}
