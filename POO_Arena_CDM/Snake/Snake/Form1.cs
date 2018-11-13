/*************************************************
 * Auteur         : Guillaume Pin
 * Co-Auteur      : Kilian Périsset, Dylan Schito, Robin Brunazzi
 * Nom du fichier : Snake
 * Description    : Jeu du Snake digne du nokia 3310
 * Date           : 13 novembre 2018
 * Version        : 2.0
 *************************************************/
using System.Windows.Forms;

namespace Snake
{
    public partial class Form1 : Form
    {
        Jeu snake;
        public Form1()
        {
            InitializeComponent();
            // Améliore l'affichage
            DoubleBuffered = true;
        }

        private void btnRestart_Click(object sender, System.EventArgs e)
        {
            // Instancie le jeu
            snake = new Jeu(this, lblScore,25, 25);
        }
    }
}
