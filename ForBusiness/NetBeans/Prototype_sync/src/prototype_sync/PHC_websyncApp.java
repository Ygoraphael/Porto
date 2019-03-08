/*
 * PHC_websyncApp.java
 */
package prototype_sync;

import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;

/**
 * The main class of the application.
 */
public class PHC_websyncApp extends SingleFrameApplication {

    @Override
    protected void startup() {
    }

    @Override
    protected void configureWindow(java.awt.Window root) {
    }

    @Override
    protected void initialize(String[] args) {
        PHC_websyncView view = new PHC_websyncView(this);
        boolean auto = false;
        
        for (String arg : args) {
            if( arg.equals("-auto") ) {
                auto = true;
            }
        }
        
        show(view);
        
        if( auto ) {
            view.start_background();
        }
    }

    public static PHC_websyncApp getApplication() {
        return Application.getInstance(PHC_websyncApp.class);
    }

    public static void main(String[] args) {
        launch(PHC_websyncApp.class, args);
    }
}
