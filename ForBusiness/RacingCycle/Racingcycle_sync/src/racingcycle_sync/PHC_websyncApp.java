/*
 * PHC_websyncApp.java
 */

package racingcycle_sync;

import main_application.RunnableThread;
import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;
import static racingcycle_sync.PHC_websyncView.application_state;

/**
 * The main class of the application.
 */
public class PHC_websyncApp extends SingleFrameApplication {

    @Override
    protected void initialize(String[] args) {
        if( args.length > 0 && args[0].equals("-autostart")) {
           
            RunnableThread update_process = null;
            update_process = new RunnableThread();
            update_process.resume();
            application_state = 1;
        }
        else {
            show(new PHC_websyncView(this));
        }
    }
    
    @Override protected void startup() { 
    }

    @Override protected void configureWindow(java.awt.Window root) {
    }

    public static PHC_websyncApp getApplication() {
        return Application.getInstance(PHC_websyncApp.class);
    }

    public static void main(String[] args) {
        launch(PHC_websyncApp.class, args);
    }
}
